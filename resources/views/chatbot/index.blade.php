<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="section-label"><i class="bi bi-robot"></i> Assistant IA</div>
            <h2 class="mb-0" style="font-size:1.5rem;">Votre assistant solidaire</h2>
            <p class="header-sub mb-0">Posez votre question, je vous guide vers la bonne cause.</p>
        </div>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-7 col-xl-6">
            <div class="cb-frame">

                <!-- Header -->
                <div class="cb-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="cb-bot-avatar">
                            <i class="bi bi-robot"></i>
                        </div>
                        <div>
                            <div class="cb-bot-name">Assistant IA</div>
                            <div class="cb-bot-status">
                                <span class="cb-dot-online"></span>
                                En ligne — CharityLink
                            </div>
                        </div>
                    </div>
                    <span class="cb-badge-ai d-none d-sm-inline-flex">
                        <i class="bi bi-cpu"></i> IA
                    </span>
                </div>

                <!-- Messages -->
                <div id="chat-messages" class="cb-body">

                    <!-- Welcome Message -->
                    <div class="cb-msg cb-msg--bot">
                        <div class="cb-msg-avatar">
                            <i class="bi bi-robot"></i>
                        </div>
                        <div class="cb-msg-bubble">
                            <div class="cb-msg-welcome">Bienvenue sur CharityLink ! 💝</div>
                            <p>Je suis votre assistant intelligent. Je peux vous aider à :</p>
                            <ul>
                                <li>Trouver une association adaptée à vos valeurs</li>
                                <li>Choisir une campagne à soutenir</li>
                                <li>Comprendre comment faire un don</li>
                                <li>Répondre à vos questions sur la solidarité</li>
                            </ul>
                            <p>Que souhaitez-vous faire aujourd'hui ?</p>
                        </div>
                    </div>

                </div>

                <!-- Quick Suggestions -->
                <div class="cb-chips">
                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                        <button onclick="setMessage('Je veux aider des enfants')" class="cb-chip">
                            <i class="bi bi-people-fill"></i> Aider des enfants
                        </button>
                        <button onclick="setMessage('Quelles associations sont disponibles ?')" class="cb-chip">
                            <i class="bi bi-building"></i> Voir les associations
                        </button>
                        <button onclick="setMessage('Je veux faire un don alimentaire')" class="cb-chip">
                            <i class="bi bi-basket-fill"></i> Don alimentaire
                        </button>
                        <button onclick="setMessage('Comment faire un don ?')" class="cb-chip">
                            <i class="bi bi-question-circle-fill"></i> Comment donner ?
                        </button>
                    </div>
                </div>

                <!-- Input -->
                <div class="cb-footer">
                    <form onsubmit="event.preventDefault(); sendMessage();" class="cb-input-wrap">
                        <div class="cb-input-box">
                            <i class="bi bi-chat-dots cb-input-icon"></i>
                            <input type="text" id="user-input"
                                placeholder="Écrivez votre message..."
                                class="cb-input"
                                onkeypress="handleKeyPress(event)"
                                autocomplete="off" />
                            <button type="submit" id="send-btn" class="cb-send-btn" aria-label="Envoyer">
                                <i class="bi bi-send-fill"></i>
                            </button>
                        </div>
                        <div class="cb-input-hint">
                            <i class="bi bi-lightning-charge-fill"></i>
                            Propulsé par l'Intelligence Artificielle
                        </div>
                    </form>
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
            div.className = 'cb-msg ' + (isUser ? 'cb-msg--user' : 'cb-msg--bot');

            const avatar = document.createElement('div');
            avatar.className = 'cb-msg-avatar';
            if (isUser) {
                avatar.classList.add('cb-msg-avatar--user');
                avatar.innerHTML = '<i class="bi bi-person-fill"></i>';
            } else {
                avatar.innerHTML = '<i class="bi bi-robot"></i>';
            }

            const bubble = document.createElement('div');
            bubble.className = 'cb-msg-bubble';
            if (isUser) bubble.classList.add('cb-msg-bubble--user');

            if (isUser) {
                bubble.textContent = text;
            } else {
                const formatted = text
                    .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                    .replace(/\n/g, '<br>');
                bubble.innerHTML = formatted;
            }

            div.appendChild(avatar);
            div.appendChild(bubble);
            container.appendChild(div);
            container.scrollTop = container.scrollHeight;
        }

        function addTyping() {
            const container = document.getElementById('chat-messages');
            const div = document.createElement('div');
            div.id = 'typing-indicator';
            div.className = 'cb-msg cb-msg--bot';
            div.innerHTML = `
                <div class="cb-msg-avatar"><i class="bi bi-robot"></i></div>
                <div class="cb-msg-bubble">
                    <div class="cb-typing"><span></span><span></span><span></span></div>
                </div>`;
            container.appendChild(div);
            container.scrollTop = container.scrollHeight;
        }

        function removeTyping() {
            const t = document.getElementById('typing-indicator');
            if (t) t.remove();
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
                addMessage('❌ Erreur de connexion. Veuillez réessayer.');
            }

            document.getElementById('send-btn').disabled = false;
            input.focus();
        }
    </script>

    <style>
        /* ══════════════ CHAT FRAME ══════════════ */
        .cb-frame {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 100px);
            min-height: 420px;
            border-radius: var(--radius-xl);
            overflow: hidden;
            border: 1px solid var(--cl-card-border);
            background: var(--cl-card-bg);
            box-shadow: var(--shadow-lg);
            transition: all 0.35s ease;
        }

        /* ══════════════ HEADER ══════════════ */
        .cb-header {
            padding: 1rem 1.5rem;
            background: var(--cl-blue);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }
        .cb-bot-avatar {
            width: 44px; height: 44px;
            background: rgba(255,255,255,0.12);
            border-radius: var(--radius-md);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .cb-bot-avatar i { font-size: 1.2rem; color: #fff; }
        .cb-bot-name {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
            color: #fff;
        }
        .cb-bot-status {
            font-size: 0.73rem;
            color: rgba(255,255,255,0.45);
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 1px;
        }
        .cb-dot-online {
            width: 6px; height: 6px;
            background: var(--cl-green);
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 6px rgba(45,198,83,0.5);
            animation: cb-pulse-dot 2s ease-in-out infinite;
        }
        @keyframes cb-pulse-dot {
            0%,100% { opacity:1; }
            50% { opacity:0.4; }
        }
        .cb-badge-ai {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: var(--radius-full);
            padding: 0.3rem 0.7rem;
            font-size: 0.68rem;
            font-weight: 600;
            color: rgba(255,255,255,0.8);
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }
        .cb-badge-ai i { font-size: 0.7rem; }

        /* ══════════════ MESSAGES BODY ══════════════ */
        .cb-body {
            flex: 1;
            overflow-y: auto;
            padding: 1.5rem;
            background: var(--cl-light);
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            transition: background 0.35s ease;
        }
        .cb-body::-webkit-scrollbar { width: 5px; }
        .cb-body::-webkit-scrollbar-track { background: transparent; }
        .cb-body::-webkit-scrollbar-thumb { background: var(--cl-border); border-radius: 10px; }
        html.dark .cb-body::-webkit-scrollbar-thumb { background: #475569; }

        /* ══════════════ MESSAGE ══════════════ */
        .cb-msg {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            animation: cb-msg-in 0.35s cubic-bezier(0.22, 1, 0.3, 1) both;
        }
        .cb-msg--user { flex-direction: row-reverse; }
        @keyframes cb-msg-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Avatar */
        .cb-msg-avatar {
            width: 34px; height: 34px;
            background: var(--cl-blue);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            margin-top: 2px;
            transition: background 0.35s ease;
        }
        .cb-msg-avatar i { font-size: 0.85rem; color: #fff; }
        .cb-msg-avatar--user {
            background: var(--cl-red);
        }

        /* Bubble */
        .cb-msg-bubble {
            background: var(--cl-card-bg);
            border-radius: 4px 18px 18px 18px;
            padding: 0.85rem 1.15rem;
            max-width: 78%;
            font-size: 0.88rem;
            line-height: 1.7;
            color: var(--cl-body);
            box-shadow: var(--shadow-xs);
            border: 1px solid var(--cl-border);
            transition: all 0.35s ease;
        }
        .cb-msg-bubble strong { color: var(--cl-red); }
        .cb-msg-bubble ul {
            padding-left: 1.2rem;
            margin: 0.5rem 0;
            color: var(--cl-body);
        }
        .cb-msg-bubble li { margin-bottom: 0.3rem; }
        .cb-msg-bubble p { margin-bottom: 0.5rem; }
        .cb-msg-bubble p:last-child { margin-bottom: 0; }

        .cb-msg-bubble--user {
            background: var(--cl-red);
            color: #fff;
            border-radius: 18px 4px 18px 4px;
            border: none;
            box-shadow: 0 2px 10px rgba(230,57,70,0.2);
        }
        .cb-msg-bubble--user strong { color: #ffd5d8; }
        .cb-msg-bubble--user ul { color: rgba(255,255,255,0.85); }
        .cb-msg-bubble--user li::marker { color: rgba(255,255,255,0.5); }

        /* Welcome Title */
        .cb-msg-welcome {
            font-family: 'Playfair Display', serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--cl-red);
            margin-bottom: 0.5rem;
        }

        /* Typing Indicator */
        .cb-typing {
            display: flex;
            gap: 5px;
            align-items: center;
            height: 20px;
            padding: 0.3rem 0;
        }
        .cb-typing span {
            width: 8px; height: 8px;
            background: var(--cl-muted-light);
            border-radius: 50%;
            animation: cb-dot-bounce 1.4s ease-in-out infinite;
        }
        .cb-typing span:nth-child(2) { animation-delay: 0.15s; }
        .cb-typing span:nth-child(3) { animation-delay: 0.3s; }
        @keyframes cb-dot-bounce {
            0%,60%,100% { transform: translateY(0); background: var(--cl-muted-light); }
            30% { transform: translateY(-5px); background: var(--cl-red); }
        }

        /* ══════════════ CHIPS ══════════════ */
        .cb-chips {
            padding: 0.6rem 1.25rem;
            background: var(--cl-card-bg);
            border-top: 1px solid var(--cl-border);
            flex-shrink: 0;
            transition: all 0.35s ease;
        }
        .cb-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: var(--cl-light);
            border: 1px solid var(--cl-border);
            border-radius: var(--radius-full);
            padding: 0.4rem 0.85rem;
            font-size: 0.78rem;
            font-weight: 500;
            color: var(--cl-muted);
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'Inter', sans-serif;
        }
        .cb-chip i { font-size: 0.85rem; }
        .cb-chip:hover {
            background: var(--cl-red-glow);
            border-color: rgba(230,57,70,0.2);
            color: var(--cl-red);
        }

        /* ══════════════ INPUT ══════════════ */
        .cb-footer {
            padding: 0.75rem 1.25rem 0.65rem;
            background: var(--cl-card-bg);
            border-top: 1px solid var(--cl-border);
            flex-shrink: 0;
            transition: all 0.35s ease;
        }
        .cb-input-wrap {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }
        .cb-input-box {
            display: flex;
            align-items: center;
            background: var(--cl-light);
            border: 1.5px solid var(--cl-border);
            border-radius: var(--radius-md);
            padding: 0.25rem 0.25rem 0.25rem 3.5rem;
            transition: all 0.25s ease;
        }
        .cb-input-box:focus-within {
            border-color: var(--cl-red);
            box-shadow: 0 0 0 3px rgba(230,57,70,0.08) !important;
            background: var(--cl-card-bg);
        }
        .cb-input-icon {
            font-size: 1rem;
            color: var(--cl-muted);
            flex-shrink: 0;
        }
        .cb-input {
            border: none !important;
            background: transparent !important;
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            color: var(--cl-dark);
            padding: 0.5rem 0;
            outline: none !important;
            box-shadow: none !important;
            flex: 1;
        }
        .cb-input:focus {
            outline: none !important;
            box-shadow: none !important;
            border: none !important;
        }
        .cb-input::placeholder { color: var(--cl-muted-light); }

        .cb-send-btn {
            width: 42px; height: 42px;
            background: var(--cl-red);
            border: none !important;
            border-radius: var(--radius-md);
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            cursor: pointer;
            flex-shrink: 0;
            transition: all 0.25s ease;
            box-shadow: 0 2px 8px rgba(230,57,70,0.2);
            outline: none !important;
        }
        .cb-send-btn:focus {
            outline: none !important;
            box-shadow: 0 2px 8px rgba(230,57,70,0.2) !important;
        }
        .cb-send-btn:active {
            outline: none !important;
            box-shadow: none !important;
        }
        .cb-send-btn i { font-size: 0.95rem; }
        .cb-send-btn:hover:not(:disabled) {
            background: var(--cl-red-hover);
            transform: scale(1.05);
            box-shadow: 0 4px 14px rgba(230,57,70,0.3) !important;
        }
        .cb-send-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .cb-input-hint {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            font-size: 0.72rem;
            color: var(--cl-muted);
            padding: 0.2rem 0;
        }
        .cb-input-hint i {
            font-size: 0.75rem;
            color: var(--cl-green);
        }

        /* ══════════════ RESPONSIVE ══════════════ */
        @media (max-width: 991.98px) {
            .cb-frame {
                height: calc(100vh - 90px);
                min-height: 400px;
            }
        }
        @media (max-width: 767.98px) {
            .cb-frame {
                height: calc(100vh - 80px);
                min-height: 360px;
                border-radius: var(--radius-lg);
                border: none;
                box-shadow: none;
            }
            .cb-body { padding: 1.25rem; }
            .cb-msg-bubble { max-width: 85%; font-size: 0.85rem; }
            .cb-msg-avatar { width: 30px; height: 30px; }
            .cb-msg-avatar i { font-size: 0.78rem; }
            .cb-bot-avatar { width: 38px; height: 38px; }
            .cb-bot-avatar i { font-size: 1rem; }
            .cb-header { padding: 0.85rem 1.25rem; }
            .cb-bot-name { font-size: 0.88rem; }
        }
        @media (max-width: 575.98px) {
            .cb-frame {
                height: calc(100vh - 66px);
                border-radius: 0;
                min-height: 100vh;
            }
            .cb-header { padding: 0.75rem 1rem; }
            .cb-body { padding: 1rem; }
            .cb-msg-bubble { max-width: 88%; }
            .cb-chips { padding: 0.5rem 0.75rem; }
            .cb-chip { font-size: 0.72rem; padding: 0.35rem 0.7rem; }
            .cb-footer { padding: 0.6rem 0.75rem 0.5rem; }
            .cb-input-box { border-radius: var(--radius-sm); }
            .cb-input-hint { display: none; }
        }
    </style>
</x-app-layout>
