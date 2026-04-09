
        // All your JavaScript from the original HTML goes here
        // (The complete JavaScript code from the previous response)
        
        // DOM Elements
        const jobDescInput = document.getElementById('jobDesc');
        const charCounterSpan = document.getElementById('charCounter');
        const toneBtns = document.querySelectorAll('.tone-btn');
        const generateBtn = document.getElementById('generateBtn');
        const btnTextSpan = document.getElementById('btnText');
        const btnSpinner = document.getElementById('btnSpinner');
        const jobErrorDiv = document.getElementById('jobError');
        const proposalContainer = document.getElementById('proposalContainer');
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

        // Tone selector
        function setActiveToneButton(toneValue) {
            toneBtns.forEach(btn => {
                const btnTone = btn.getAttribute('data-tone');
                if (btnTone === toneValue) {
                    btn.classList.remove('bg-slate-800', 'text-indigo-300', 'border-slate-600');
                    btn.classList.add('bg-indigo-600', 'text-white', 'border-indigo-400', 'shadow-md');
                } else {
                    btn.classList.remove('bg-indigo-600', 'text-white', 'border-indigo-400', 'shadow-md');
                    btn.classList.add('bg-slate-800', 'text-indigo-300', 'border-slate-600');
                }
            });
        }

        toneBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                selectedTone = btn.getAttribute('data-tone');
                setActiveToneButton(selectedTone);
            });
        });
        
        setActiveToneButton('professional');

        // Reset output area
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

        // Copy to clipboard
        async function copyToClipboard(text, buttonElement) {
            if (!text) return;
            try {
                await navigator.clipboard.writeText(text);
                const originalHTML = buttonElement.innerHTML;
                buttonElement.innerHTML = '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Copied!';
                buttonElement.classList.add('bg-indigo-700', 'text-white');
                setTimeout(() => {
                    buttonElement.innerHTML = originalHTML;
                    buttonElement.classList.remove('bg-indigo-700', 'text-white');
                }, 1800);
            } catch (err) {
                console.warn('Clipboard failed', err);
            }
        }

        // Render proposal cards
        function renderProposalCards(proposal) {
            const sections = [
                { key: 'opening', label: '🌟 Opening', defaultText: '' },
                { key: 'understanding', label: '📖 Understanding', defaultText: '' },
                { key: 'fit', label: '🎯 Why I\'m a Great Fit', defaultText: '' },
                { key: 'approach', label: '⚙️ My Approach', defaultText: '' },
                { key: 'closing', label: '🔚 Closing', defaultText: '' }
            ];

            let cardsHTML = '';
            for (let sec of sections) {
                const content = proposal[sec.key] || 'No content generated.';
                cardsHTML += `
                    <div class="bg-slate-800/90 backdrop-blur-sm border border-slate-700/80 rounded-xl p-5 transition-all hover:border-indigo-500/40 shadow-md animate-fade-in-up">
                        <div class="flex justify-between items-start flex-wrap gap-2 mb-3">
                            <h3 class="font-bold text-indigo-300 text-lg tracking-tight">${sec.label}</h3>
                            <button class="copy-section-btn text-xs bg-slate-700 hover:bg-indigo-800/60 text-gray-300 hover:text-white px-3 py-1.5 rounded-lg transition flex items-center gap-1" data-section-content="${escapeHtml(content)}">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                                Copy
                            </button>
                        </div>
                        <p class="text-gray-200 leading-relaxed text-sm md:text-base whitespace-pre-line">${escapeHtml(content)}</p>
                    </div>
                `;
            }
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
        }

        // Copy full proposal
        async function copyFullProposal() {
            if (!currentProposalData) return;
            const { opening, understanding, fit, approach, closing } = currentProposalData;
            const fullText = `🌟 OPENING\n${opening || ''}\n\n📖 UNDERSTANDING\n${understanding || ''}\n\n🎯 WHY I'M A GREAT FIT\n${fit || ''}\n\n⚙️ MY APPROACH\n${approach || ''}\n\n🔚 CLOSING\n${closing || ''}`;
            try {
                await navigator.clipboard.writeText(fullText);
                const originalLabel = copyFullBtn.innerHTML;
                copyFullBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Copied!';
                setTimeout(() => {
                    copyFullBtn.innerHTML = originalLabel;
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
                // Get CSRF token from meta tag (Laravel)
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
                        <button id="retryBtn" class="mt-2 text-sm bg-indigo-700/50 hover:bg-indigo-600 px-3 py-1 rounded-lg transition">⟳ Retry generation</button></div>
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
  