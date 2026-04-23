<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🤖 {{ __('Assistant Charity-Link') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow overflow-hidden">

                <!-- Header chatbot -->
                <div class="bg-blue-600 p-4 text-white">
                    <h3 class="font-semibold text-lg">🤖 Assistant Gemini AI</h3>
                    <p class="text-blue-200 text-sm">
                        Je vous aide à choisir l'association à soutenir
                    </p>
                </div>

                <!-- Messages -->
                <div id="chat-messages"
                    class="h-96 overflow-y-auto p-4 space-y-4 bg-gray-50">

                    <!-- Message de bienvenue -->
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm flex-shrink-0">
                            🤖
                        </div>
                        <div class="bg-white rounded-lg p-3 shadow-sm max-w-md">
                            <p class="text-gray-800 text-sm">
                                Bonjour ! Je suis l'assistant de Charity-Link.
                                Je peux vous aider à choisir une association à soutenir.
                                Que souhaitez-vous faire aujourd'hui ?
                            </p>
                        </div>
                    </div>

                </div>

                <!-- Input -->
                <div class="p-4 border-t bg-white">
                    <div class="flex gap-3">
                        <input type="text" id="user-input"
                            placeholder="Ex: Je veux aider des enfants..."
                            class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500 text-sm"
                            onkeypress="handleKeyPress(event)" />
                        <button onclick="sendMessage()"
                            id="send-btn"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            Envoyer
                        </button>
                    </div>

                    <!-- Suggestions rapides -->
                    <div class="mt-3 flex flex-wrap gap-2">
                        <button onclick="setMessage('Je veux aider des enfants')"
                            class="text-xs bg-gray-100 text-gray-600 px-3 py-1 rounded-full hover:bg-gray-200">
                            Aider des enfants
                        </button>
                        <button onclick="setMessage('Quelles associations sont disponibles ?')"
                            class="text-xs bg-gray-100 text-gray-600 px-3 py-1 rounded-full hover:bg-gray-200">
                            Voir les associations
                        </button>
                        <button onclick="setMessage('Je veux faire un don alimentaire')"
                            class="text-xs bg-gray-100 text-gray-600 px-3 py-1 rounded-full hover:bg-gray-200">
                            Don alimentaire
                        </button>
                        <button onclick="setMessage('Comment faire un don ?')"
                            class="text-xs bg-gray-100 text-gray-600 px-3 py-1 rounded-full hover:bg-gray-200">
                            Comment donner ?
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        const csrfToken = '{{ csrf_token() }}';

        function handleKeyPress(event) {
            if (event.key === 'Enter') sendMessage();
        }

        function setMessage(text) {
            document.getElementById('user-input').value = text;
            sendMessage();
        }

        function addMessage(text, isUser = false) {
            const container = document.getElementById('chat-messages');
            const div = document.createElement('div');
            div.className = 'flex items-start gap-3' + (isUser ? ' flex-row-reverse' : '');

            const avatar = document.createElement('div');
            avatar.className = isUser
                ? 'w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-sm flex-shrink-0'
                : 'w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm flex-shrink-0';
            avatar.textContent = isUser ? '👤' : '🤖';

            const bubble = document.createElement('div');
            bubble.className = isUser
                ? 'bg-green-50 rounded-lg p-3 shadow-sm max-w-md'
                : 'bg-white rounded-lg p-3 shadow-sm max-w-md';

            const p = document.createElement('p');
            p.className = 'text-gray-800 text-sm whitespace-pre-wrap';
            p.textContent = text;

            bubble.appendChild(p);
            div.appendChild(avatar);
            div.appendChild(bubble);
            container.appendChild(div);
            container.scrollTop = container.scrollHeight;
        }

        function addTyping() {
            const container = document.getElementById('chat-messages');
            const div = document.createElement('div');
            div.id = 'typing-indicator';
            div.className = 'flex items-start gap-3';
            div.innerHTML = `
                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm flex-shrink-0">🤖</div>
                <div class="bg-white rounded-lg p-3 shadow-sm">
                    <p class="text-gray-500 text-sm">En train d'écrire...</p>
                </div>`;
            container.appendChild(div);
            container.scrollTop = container.scrollHeight;
        }

        function removeTyping() {
            const typing = document.getElementById('typing-indicator');
            if (typing) typing.remove();
        }

        async function sendMessage() {
            const input = document.getElementById('user-input');
            const message = input.value.trim();
            if (!message) return;

            addMessage(message, true);
            input.value = '';
            document.getElementById('send-btn').disabled = true;
            addTyping();

            try {
                const response = await fetch('{{ route("chatbot.chat") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ message })
                });

                const data = await response.json();
                removeTyping();
                addMessage(data.response);

            } catch (error) {
                removeTyping();
                addMessage('Erreur de connexion. Veuillez réessayer.');
            }

            document.getElementById('send-btn').disabled = false;
            input.focus();
        }
    </script>
</x-app-layout>
