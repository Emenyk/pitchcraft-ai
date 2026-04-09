<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PitchCraft AI · Generate Your Proposal</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Custom animations matching welcome page */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideInFromLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes slideInFromRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes pulse-glow {
            0%, 100% { 
                opacity: 0.3;
                transform: scale(1);
            }
            50% { 
                opacity: 0.6;
                transform: scale(1.05);
            }
        }
        
        @keyframes rotate-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }
            100% {
                background-position: 1000px 0;
            }
        }
        
        .animate-fade-up {
            animation: fadeInUp 0.6s ease-out;
        }
        
        .animate-slide-left {
            animation: slideInFromLeft 0.6s ease-out;
        }
        
        .animate-slide-right {
            animation: slideInFromRight 0.6s ease-out;
        }
        
        .animate-pulse-glow {
            animation: pulse-glow 3s ease-in-out infinite;
        }
        
        .rotate-slow {
            animation: rotate-slow 20s linear infinite;
        }
        
        .shimmer-effect {
            background: linear-gradient(90deg, transparent, rgba(99, 102, 241, 0.1), transparent);
            background-size: 1000px 100%;
            animation: shimmer 2s infinite;
        }
        
        /* Custom scrollbar */
        .custom-scroll::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scroll::-webkit-scrollbar-track {
            background: #1e293b;
            border-radius: 8px;
        }
        
        .custom-scroll::-webkit-scrollbar-thumb {
            background: #4f46e5;
            border-radius: 8px;
        }
        
        .custom-scroll::-webkit-scrollbar-thumb:hover {
            background: #6366f1;
        }
        
        /* Card hover effects */
        .proposal-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .proposal-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.2);
        }
        
        /* Button hover effects */
        .generate-btn {
            position: relative;
            overflow: hidden;
        }
        
        .generate-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .generate-btn:hover::before {
            width: 300px;
            height: 300px;
        }
        
        /* Tone button active animation */
        .tone-btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .tone-btn:active {
            transform: scale(0.95);
        }
        
        /* Loading spinner animation */
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .spinner {
            animation: spin 0.8s linear infinite;
        }
        
        /* Focus styles */
        button:focus-visible, 
        textarea:focus-visible, 
        select:focus-visible {
            outline: 2px solid #818cf8;
            outline-offset: 2px;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-900 font-sans antialiased">
    
    <!-- Animated Background Orbs -->
    <div class="fixed top-20 -right-48 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl animate-pulse-glow pointer-events-none"></div>
    <div class="fixed bottom-20 -left-48 w-96 h-96 bg-violet-600/20 rounded-full blur-3xl animate-pulse-glow pointer-events-none" style="animation-delay: 1.5s;"></div>
    
    <!-- Navigation Bar -->
    <nav class="sticky top-0 z-50 bg-slate-900/80 backdrop-blur-md border-b border-slate-700/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-gradient-to-br from-indigo-500 to-violet-600 p-2 rounded-xl rotate-slow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z" />
                            <path d="M17 4v4" /><path d="M21 8h-4" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-xl font-bold bg-gradient-to-r from-white via-indigo-200 to-indigo-400 bg-clip-text text-transparent">PitchCraft AI</span>
                        <p class="text-xs text-indigo-300/70 hidden sm:block">Proposal Generator</p>
                    </div>
                </div>
                <div class="hidden md:flex items-center gap-8">
                    <a href="/" class="text-gray-300 hover:text-white transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Home
                    </a>
                    <a href="#proposal-area" class="text-gray-300 hover:text-white transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Generator
                    </a>
                    <a href="#features" class="text-gray-300 hover:text-white transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                        </svg>
                        Features
                    </a>
                </div>
                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex items-center gap-2 text-sm text-indigo-300 bg-indigo-600/20 px-3 py-1.5 rounded-full">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                        </span>
                        <span>AI Ready</span>
                    </div>
                    <a href="/" class="bg-indigo-600 hover:bg-indigo-500 px-4 py-2 rounded-lg font-semibold transition-all transform hover:scale-105 shadow-lg shadow-indigo-600/30 text-sm">
                        ← Back
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-10">
        <!-- Header Banner -->
        <div class="bg-gradient-to-r from-indigo-600/10 via-violet-600/10 to-purple-600/10 rounded-2xl p-6 mb-8 border border-indigo-500/20 animate-slide-left">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-white via-indigo-200 to-indigo-400 bg-clip-text text-transparent">
                        Generate Your Winning Proposal
                    </h1>
                    <p class="text-gray-400 text-sm md:text-base mt-1">Fill in the details below and let AI craft your perfect pitch</p>
                </div>
                <div class="flex gap-2 text-xs text-indigo-300">
                    <div class="bg-slate-800/50 px-3 py-1.5 rounded-lg">⚡ 10 sec generation</div>
                    <div class="bg-slate-800/50 px-3 py-1.5 rounded-lg">🎯 98% success rate</div>
                </div>
            </div>
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-10">
            
            <!-- LEFT COLUMN: Input Form -->
            <div class="space-y-6 animate-slide-left">
                <!-- Job Description -->
                <div class="bg-slate-800/30 rounded-xl p-6 border border-slate-700/50">
                    <label class="block text-sm font-semibold text-indigo-300 mb-3 flex justify-between">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Job Description
                        </span>
                        <span id="charCounter" class="text-xs text-gray-400 font-normal">0 characters</span>
                    </label>
                    <textarea id="jobDesc" rows="6" 
                        placeholder="Paste the client's job post or project brief here... (e.g., Need a responsive e-commerce site with payment integration)"
                        class="w-full bg-slate-900/50 border border-slate-700 rounded-xl p-4 text-gray-200 placeholder:text-gray-500 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 transition resize-y"></textarea>
                    <div id="jobError" class="text-rose-400 text-sm mt-2 hidden flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Job description cannot be empty
                    </div>
                </div>

                <!-- Tone Selector -->
                <div class="bg-slate-800/30 rounded-xl p-6 border border-slate-700/50">
                    <label class="block text-sm font-semibold text-indigo-300 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
                        </svg>
                        Tone of Proposal
                    </label>
                    <div class="flex flex-wrap gap-3" id="toneGroup">
                        <button data-tone="professional" class="tone-btn px-5 py-2.5 rounded-full text-sm font-medium transition-all bg-gradient-to-r from-indigo-600 to-indigo-700 text-white shadow-lg shadow-indigo-600/30">
                            📌 Professional
                        </button>
                        <button data-tone="confident" class="tone-btn px-5 py-2.5 rounded-full text-sm font-medium transition-all bg-slate-800 text-indigo-300 border border-slate-600 hover:border-indigo-400">
                            ⚡ Confident
                        </button>
                        <button data-tone="short" class="tone-btn px-5 py-2.5 rounded-full text-sm font-medium transition-all bg-slate-800 text-indigo-300 border border-slate-600 hover:border-indigo-400">
                            ✂️ Short
                        </button>
                    </div>
                </div>

                <!-- Generate Button -->
                <button id="generateBtn" class="generate-btn w-full bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 transition-all duration-200 py-4 rounded-xl font-semibold text-white shadow-lg shadow-indigo-600/30 flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed relative overflow-hidden">
                    <span id="btnText">✨ Generate Proposal</span>
                    <span id="btnSpinner" class="hidden">
                        <svg class="spinner h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>

                <!-- Tips Card -->
                <div class="bg-indigo-600/10 rounded-xl p-4 border border-indigo-500/20">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-xs text-gray-400">
                            <p class="font-semibold text-indigo-300 mb-1">💡 Pro Tip</p>
                            <p>Include specific project requirements and deliverables for better AI-generated proposals.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: Proposal Output -->
            <div id="proposal-area" class="bg-slate-900/40 rounded-2xl border border-slate-800/60 p-5 backdrop-blur-sm animate-slide-right">
                <div class="flex items-center justify-between border-b border-slate-800 pb-3 mb-5 flex-wrap gap-2">
                    <h2 class="text-xl font-bold flex items-center gap-2">
                        <span class="text-indigo-400">✍️</span> 
                        <span class="bg-gradient-to-r from-white to-indigo-200 bg-clip-text text-transparent">AI Proposal</span>
                    </h2>
                    <button id="copyFullProposalBtn" class="text-sm bg-slate-800 hover:bg-slate-700 px-3 py-1.5 rounded-lg transition flex items-center gap-1.5 text-indigo-300 disabled:opacity-40 disabled:cursor-not-allowed">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                        </svg>
                        Copy Full Proposal
                    </button>
                </div>
                
                <!-- Dynamic proposal container -->
                <div id="proposalContainer" class="space-y-5 max-h-[65vh] overflow-y-auto pr-2 custom-scroll">
                    <!-- Placeholder State -->
                    <div id="placeholderState" class="flex flex-col items-center justify-center py-12 px-4 text-center text-gray-400">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/20 to-violet-500/20 rounded-full blur-xl animate-pulse"></div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-indigo-500/40 mb-4 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <p class="text-lg font-medium text-white mt-4">Ready to create magic</p>
                        <p class="text-sm max-w-xs mt-2">Fill in the job description, choose your tone, and let AI craft a winning proposal for you.</p>
                        <div class="mt-6 flex gap-2">
                            <div class="w-2 h-2 rounded-full bg-indigo-400 animate-pulse"></div>
                            <div class="w-2 h-2 rounded-full bg-indigo-400 animate-pulse" style="animation-delay: 0.2s"></div>
                            <div class="w-2 h-2 rounded-full bg-indigo-400 animate-pulse" style="animation-delay: 0.4s"></div>
                        </div>
                    </div>
                    
                    <!-- Dynamic cards will appear here -->
                    <div id="proposalCards" class="space-y-4 hidden"></div>
                    
                    <!-- Error message area -->
                    <div id="apiErrorMsg" class="hidden bg-rose-900/40 border border-rose-700/50 rounded-xl p-4 text-rose-300 text-sm"></div>
                </div>
            </div>
        </div>

        <!-- Features Mini Section -->
        <div id="features" class="mt-12 pt-8 border-t border-slate-800">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center p-3">
                    <div class="text-2xl mb-1">⚡</div>
                    <div class="text-xs text-gray-400">Lightning Fast</div>
                </div>
                <div class="text-center p-3">
                    <div class="text-2xl mb-1">🎯</div>
                    <div class="text-xs text-gray-400">High Accuracy</div>
                </div>
                <div class="text-center p-3">
                    <div class="text-2xl mb-1">🔒</div>
                    <div class="text-xs text-gray-400">Secure & Private</div>
                </div>
                <div class="text-center p-3">
                    <div class="text-2xl mb-1">💎</div>
                    <div class="text-xs text-gray-400">Free Forever</div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="mt-8 pt-6 border-t border-slate-800 text-center text-gray-500 text-sm">
            <p>Powered by Laravel AI SDK · PitchCraft AI — Smart proposals for freelancers</p>
            <p class="text-xs mt-2">© 2024 PitchCraft AI. All rights reserved.</p>
        </footer>
    </div>

    <script>
        // DOM Elements
        const jobDescInput = document.getElementById('jobDesc');
        const charCounterSpan = document.getElementById('charCounter');
        const toneBtns = document.querySelectorAll('.tone-btn');
        const generateBtn = document.getElementById('generateBtn');
        const btnTextSpan = document.getElementById('btnText');
        const btnSpinner = document.getElementById('btnSpinner');
        const jobErrorDiv = document.getElementById('jobError');
        const placeholderDiv = document.getElementById('placeholderState');
        const proposalCardsDiv = document.getElementById('proposalCards');
        const apiErrorMsgDiv = document.getElementById('apiErrorMsg');
        const copyFullBtn = document.getElementById('copyFullProposalBtn');

        // State
        let selectedTone = 'professional';
        let currentProposalData = null;
        let isGenerating = false;

        // Character count update
        function updateCharCount() {
            const len = jobDescInput.value.length;
            charCounterSpan.innerText = `${len} character${len !== 1 ? 's' : ''}`;
            if (len > 0 && !jobErrorDiv.classList.contains('hidden')) {
                jobErrorDiv.classList.add('hidden');
            }
        }

        jobDescInput.addEventListener('input', updateCharCount);
        updateCharCount();

        // Tone selector with animation
        function setActiveToneButton(toneValue) {
            toneBtns.forEach(btn => {
                const btnTone = btn.getAttribute('data-tone');
                if (btnTone === toneValue) {
                    btn.classList.remove('bg-slate-800', 'text-indigo-300', 'border-slate-600');
                    btn.classList.add('bg-gradient-to-r', 'from-indigo-600', 'to-indigo-700', 'text-white', 'shadow-lg', 'shadow-indigo-600/30');
                } else {
                    btn.classList.remove('bg-gradient-to-r', 'from-indigo-600', 'to-indigo-700', 'text-white', 'shadow-lg', 'shadow-indigo-600/30');
                    btn.classList.add('bg-slate-800', 'text-indigo-300', 'border-slate-600');
                }
            });
        }

        toneBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                selectedTone = btn.getAttribute('data-tone');
                setActiveToneButton(selectedTone);
                // Add subtle haptic feedback (optional)
                btn.style.transform = 'scale(0.95)';
                setTimeout(() => { btn.style.transform = 'scale(1)'; }, 150);
            });
        });
        
        setActiveToneButton('professional');

        // Reset output area with animation
        function resetOutputArea() {
            proposalCardsDiv.classList.add('hidden');
            placeholderDiv.classList.remove('hidden');
            apiErrorMsgDiv.classList.add('hidden');
            apiErrorMsgDiv.innerHTML = '';
            currentProposalData = null;
            copyFullBtn.disabled = true;
            copyFullBtn.classList.add('opacity-50');
        }

        // Escape HTML helper
        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        // Copy to clipboard with animation
        async function copyToClipboard(text, buttonElement) {
            if (!text) return;
            try {
                await navigator.clipboard.writeText(text);
                const originalHTML = buttonElement.innerHTML;
                buttonElement.innerHTML = '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Copied!';
                buttonElement.classList.add('bg-green-600', 'text-white');
                setTimeout(() => {
                    buttonElement.innerHTML = originalHTML;
                    buttonElement.classList.remove('bg-green-600', 'text-white');
                }, 1800);
            } catch (err) {
                console.warn('Clipboard failed', err);
                const originalText = buttonElement.innerText;
                buttonElement.innerText = '⚠️ Failed';
                setTimeout(() => buttonElement.innerText = originalText, 1500);
            }
        }

        // Render proposal cards with animations
        function renderProposalCards(proposal) {
            const sections = [
                { key: 'opening', label: '🌟 Opening', icon: '✨', color: 'indigo' },
                { key: 'understanding', label: '📖 Understanding', icon: '🎯', color: 'violet' },
                { key: 'fit', label: '💪 Why I\'m a Great Fit', icon: '🏆', color: 'purple' },
                { key: 'approach', label: '⚙️ My Approach', icon: '🔧', color: 'blue' },
                { key: 'closing', label: '🔚 Closing', icon: '🤝', color: 'pink' }
            ];

            let cardsHTML = '';
            sections.forEach((sec, index) => {
                const content = proposal[sec.key] || 'No content generated.';
                cardsHTML += `
                    <div class="proposal-card bg-gradient-to-br from-slate-800/90 to-slate-900/90 backdrop-blur-sm border border-slate-700/80 rounded-xl p-5 transition-all hover:border-${sec.color}-500/40 shadow-md animate-fade-up" style="animation-delay: ${index * 0.1}s">
                        <div class="flex justify-between items-start flex-wrap gap-2 mb-3">
                            <h3 class="font-bold text-${sec.color}-300 text-lg tracking-tight flex items-center gap-2">
                                <span class="text-xl">${sec.icon}</span>
                                ${sec.label}
                            </h3>
                            <button class="copy-section-btn text-xs bg-slate-700 hover:bg-${sec.color}-800/60 text-gray-300 hover:text-white px-3 py-1.5 rounded-lg transition flex items-center gap-1" data-section-content="${escapeHtml(content)}">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                                Copy
                            </button>
                        </div>
                        <p class="text-gray-200 leading-relaxed text-sm md:text-base whitespace-pre-line">${escapeHtml(content)}</p>
                    </div>
                `;
            });
            
            proposalCardsDiv.innerHTML = cardsHTML;
            
            document.querySelectorAll('.copy-section-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const textToCopy = btn.getAttribute('data-section-content');
                    copyToClipboard(textToCopy, btn);
                });
            });
            
            proposalCardsDiv.classList.remove('hidden');
            placeholderDiv.classList.add('hidden');
            copyFullBtn.disabled = false;
            copyFullBtn.classList.remove('opacity-50');
            
            // Scroll to proposal area smoothly
            document.getElementById('proposal-area')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        // Copy full proposal
        async function copyFullProposal() {
            if (!currentProposalData) return;
            const { opening, understanding, fit, approach, closing } = currentProposalData;
            const fullText = `🌟 OPENING\n${opening || ''}\n\n📖 UNDERSTANDING\n${understanding || ''}\n\n💪 WHY I'M A GREAT FIT\n${fit || ''}\n\n⚙️ MY APPROACH\n${approach || ''}\n\n🔚 CLOSING\n${closing || ''}`;
            try {
                await navigator.clipboard.writeText(fullText);
                const originalLabel = copyFullBtn.innerHTML;
                copyFullBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Copied!';
                copyFullBtn.classList.add('bg-green-600', 'text-white');
                setTimeout(() => {
                    copyFullBtn.innerHTML = originalLabel;
                    copyFullBtn.classList.remove('bg-green-600', 'text-white');
                }, 2000);
            } catch (err) {
                alert('Unable to copy full proposal');
            }
        }

        copyFullBtn.addEventListener('click', copyFullProposal);

        // Generate proposal API call
        async function generateProposal() {
            const jobDescription = jobDescInput.value.trim();
            
            if (!jobDescription) {
                jobErrorDiv.classList.remove('hidden');
                jobDescInput.focus();
                jobDescInput.classList.add('border-rose-500');
                setTimeout(() => jobDescInput.classList.remove('border-rose-500'), 2000);
                return;
            } else {
                jobErrorDiv.classList.add('hidden');
            }
            
            if (isGenerating) return;
            isGenerating = true;
            
            generateBtn.disabled = true;
            btnTextSpan.innerText = 'Generating...';
            btnSpinner.classList.remove('hidden');
            resetOutputArea();
            
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                
                const response = await fetch('/api/generate-proposal', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken || '',
                    },
                    body: JSON.stringify({
                        job_description: jobDescription,
                        tone: selectedTone
                    }),
                });
                
                if (!response.ok) {
                    let errorDetail = `Server responded with ${response.status}`;
                    try {
                        const errData = await response.json();
                        errorDetail = errData.message || errData.error || errorDetail;
                    } catch (e) {}
                    throw new Error(errorDetail);
                }
                
                const data = await response.json();
                const proposal = {
                    opening: data.opening || "We'll craft a compelling opening based on your requirements.",
                    understanding: data.understanding || "Deep understanding of project goals.",
                    fit: data.fit || "Strong alignment with your needs.",
                    approach: data.approach || "Proven workflow delivering results.",
                    closing: data.closing || "Looking forward to collaborating!"
                };
                
                currentProposalData = proposal;
                renderProposalCards(proposal);
                
            } catch (error) {
                console.error('API error:', error);
                placeholderDiv.classList.add('hidden');
                proposalCardsDiv.classList.add('hidden');
                apiErrorMsgDiv.classList.remove('hidden');
                apiErrorMsgDiv.innerHTML = `
                    <div class="flex gap-3 items-start">
                        <svg class="w-5 h-5 text-rose-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <div><strong class="font-semibold">Proposal generation failed</strong><br /> ${error.message || 'Network error or service unavailable. Please check your connection and try again.'}<br />
                        <button id="retryBtn" class="mt-3 text-sm bg-indigo-700/50 hover:bg-indigo-600 px-4 py-2 rounded-lg transition font-medium">⟳ Retry generation</button></div>
                    </div>
                `;
                const retryBtnEl = document.getElementById('retryBtn');
                if (retryBtnEl) retryBtnEl.addEventListener('click', () => generateProposal());
                currentProposalData = null;
                copyFullBtn.disabled = true;
                copyFullBtn.classList.add('opacity-50');
            } finally {
                isGenerating = false;
                generateBtn.disabled = false;
                btnTextSpan.innerText = '✨ Generate Proposal';
                btnSpinner.classList.add('hidden');
            }
        }
        
        generateBtn.addEventListener('click', generateProposal);
        copyFullBtn.disabled = true;
        copyFullBtn.classList.add('opacity-50');

        // Smooth scroll for nav links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>
</html>