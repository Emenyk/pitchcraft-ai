<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PitchCraft AI · Welcome to Smarter Proposals</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Custom animations and effects */
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        
        @keyframes float-delayed {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(-5deg); }
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
        
        @keyframes slideInFromLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes slideInFromRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes typing {
            from { width: 0; }
            to { width: 100%; }
        }
        
        @keyframes blink-caret {
            from, to { border-color: transparent; }
            50% { border-color: #818cf8; }
        }
        
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        @keyframes rotate-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        .animate-float-delayed {
            animation: float-delayed 7s ease-in-out infinite;
        }
        
        .animate-pulse-glow {
            animation: pulse-glow 3s ease-in-out infinite;
        }
        
        .animate-slide-left {
            animation: slideInFromLeft 0.8s ease-out;
        }
        
        .animate-slide-right {
            animation: slideInFromRight 0.8s ease-out;
        }
        
        .animate-fade-up {
            animation: fadeInUp 0.8s ease-out;
        }
        
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient-shift 3s ease infinite;
        }
        
        .rotate-slow {
            animation: rotate-slow 20s linear infinite;
        }
        
        .typing-text {
            overflow: hidden;
            white-space: nowrap;
            border-right: 2px solid #818cf8;
            animation: typing 3.5s steps(40, end), blink-caret 0.75s step-end infinite;
        }
        
        /* Particle background effect */
        .particle-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
        }
        
        .particle {
            position: absolute;
            background: rgba(99, 102, 241, 0.1);
            border-radius: 50%;
            pointer-events: none;
            animation: float-particle 15s infinite linear;
        }
        
        @keyframes float-particle {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh) rotate(360deg);
                opacity: 0;
            }
        }
        
        /* Card hover effects */
        .feature-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px -12px rgba(79, 70, 229, 0.3);
        }
        
        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-900 font-sans antialiased overflow-x-hidden">
    
    <!-- Particle Background -->
    <div class="particle-bg" id="particles"></div>
    
    <!-- Animated Gradient Orbs -->
    <div class="fixed top-1/4 -right-48 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl animate-pulse-glow pointer-events-none"></div>
    <div class="fixed bottom-1/4 -left-48 w-96 h-96 bg-violet-600/20 rounded-full blur-3xl animate-pulse-glow pointer-events-none" style="animation-delay: 1.5s;"></div>
    
    <div class="relative z-10">
        <!-- Navigation Bar -->
        <nav class="fixed top-0 left-0 right-0 bg-slate-900/80 backdrop-blur-md border-b border-slate-700/50 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="bg-gradient-to-br from-indigo-500 to-violet-600 p-2 rounded-xl rotate-slow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z" />
                                <path d="M17 4v4" /><path d="M21 8h-4" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-white via-indigo-200 to-indigo-400 bg-clip-text text-transparent">PitchCraft AI</span>
                    </div>
                    <div class="hidden md:flex items-center gap-8">
                        <a href="#features" class="text-gray-300 hover:text-white transition">Features</a>
                        <a href="#how-it-works" class="text-gray-300 hover:text-white transition">How it Works</a>
                        <a href="#pricing" class="text-gray-300 hover:text-white transition">Pricing</a>
                    </div>
                    <a href="/pitchcraft" class="bg-indigo-600 hover:bg-indigo-500 px-5 py-2 rounded-lg font-semibold transition-all transform hover:scale-105 shadow-lg shadow-indigo-600/30">
                        Get Started →
                    </a>
                </div>
            </div>
        </nav>

        <!-- Hero Section - Fixed Spacing -->
        <section class="relative pt-28 pb-16 md:pt-32 md:pb-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <!-- Left Content -->
                    <div class="animate-slide-left">
                        <div class="inline-flex items-center gap-2 bg-indigo-600/20 backdrop-blur-sm px-4 py-2 rounded-full border border-indigo-500/30 mb-6">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                            </span>
                            <span class="text-sm text-indigo-300 font-medium">AI-Powered Proposals</span>
                        </div>
                        
                        <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold mb-4 leading-tight">
                            <span class="bg-gradient-to-r from-white via-indigo-200 to-indigo-400 bg-clip-text text-transparent animate-gradient">
                                Generate Winning
                            </span>
                            <br>
                            <span class="text-white">Freelance Proposals</span>
                        </h1>
                        
                        <div class="text-lg md:text-xl text-gray-300 mb-4 h-12">
                            <div class="typing-text inline-block">
                                in seconds, not hours
                            </div>
                        </div>
                        
                        <p class="text-base md:text-lg text-gray-400 mb-6 max-w-lg">
                            PitchCraft AI helps you craft compelling, personalized proposals that win clients. 
                            Powered by advanced AI, tailored to your unique style.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4 mb-8">
                            <a href="/pitchcraft" class="bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 px-6 py-3 rounded-xl font-semibold transition-all transform hover:scale-105 shadow-xl flex items-center justify-center gap-2 group">
                                Start Creating Free
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                            <button onclick="document.getElementById('how-it-works').scrollIntoView({behavior: 'smooth'})" class="border border-slate-600 hover:border-indigo-500 px-6 py-3 rounded-xl font-semibold transition-all hover:bg-slate-800/50">
                                Watch Demo
                            </button>
                        </div>
                        
                        <div class="flex items-center gap-8 pt-6 border-t border-slate-700">
                            <div class="flex -space-x-2">
                                <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold border-2 border-slate-900">⭐</div>
                                <div class="w-10 h-10 rounded-full bg-violet-600 flex items-center justify-center text-white font-bold border-2 border-slate-900">🏆</div>
                                <div class="w-10 h-10 rounded-full bg-purple-600 flex items-center justify-center text-white font-bold border-2 border-slate-900">🚀</div>
                            </div>
                            <div>
                                <div class="flex text-yellow-400">
                                    ★★★★★
                                </div>
                                <p class="text-sm text-gray-400">Trusted by 5,000+ freelancers</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Illustration -->
                    <div class="relative animate-slide-right">
                        <div class="relative">
                            <!-- Floating elements -->
                            <div class="absolute -top-10 -left-10 w-32 h-32 bg-indigo-500/20 rounded-full blur-2xl animate-float pointer-events-none"></div>
                            <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-violet-500/20 rounded-full blur-2xl animate-float-delayed pointer-events-none"></div>
                            
                            <!-- Main Card -->
                            <div class="bg-gradient-to-br from-slate-800/80 to-slate-900/80 backdrop-blur-xl rounded-2xl border border-slate-700 p-6 shadow-2xl transform rotate-2 hover:rotate-0 transition-transform duration-500">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                    <div class="flex-1 text-center text-sm text-gray-400">AI Proposal Preview</div>
                                </div>
                                
                                <div class="space-y-4">
                                    <div class="bg-indigo-600/20 rounded-lg p-3 border-l-4 border-indigo-500">
                                        <div class="text-xs text-indigo-400 mb-1">✨ OPENING</div>
                                        <p class="text-sm text-gray-300">"Your project aligns perfectly with my expertise. I'm excited to bring my 8+ years of experience..."</p>
                                    </div>
                                    
                                    <div class="bg-violet-600/20 rounded-lg p-3 border-l-4 border-violet-500">
                                        <div class="text-xs text-violet-400 mb-1">📖 UNDERSTANDING</div>
                                        <p class="text-sm text-gray-300">"I understand you need a scalable solution that grows with your business..."</p>
                                    </div>
                                    
                                    <div class="bg-purple-600/20 rounded-lg p-3 border-l-4 border-purple-500">
                                        <div class="text-xs text-purple-400 mb-1">🎯 WHY ME</div>
                                        <p class="text-sm text-gray-300">"With 50+ successful projects and 100% client satisfaction rate..."</p>
                                    </div>
                                    
                                    <div class="flex justify-between items-center pt-3">
                                        <div class="flex gap-1">
                                            <div class="w-2 h-2 rounded-full bg-indigo-400 animate-pulse"></div>
                                            <div class="w-2 h-2 rounded-full bg-indigo-400 animate-pulse" style="animation-delay: 0.2s"></div>
                                            <div class="w-2 h-2 rounded-full bg-indigo-400 animate-pulse" style="animation-delay: 0.4s"></div>
                                        </div>
                                        <span class="text-xs text-indigo-400">AI Generating...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-16 md:py-20 bg-slate-900/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12 animate-fade-up">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">
                        <span class="bg-gradient-to-r from-indigo-400 to-violet-400 bg-clip-text text-transparent">
                            Powerful Features
                        </span>
                    </h2>
                    <p class="text-gray-400 text-base md:text-lg max-w-2xl mx-auto">
                        Everything you need to create winning proposals that stand out
                    </p>
                </div>
                
                <div class="grid md:grid-cols-3 gap-6 md:gap-8">
                    <div class="feature-card bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 border border-slate-700">
                        <div class="w-14 h-14 bg-indigo-600/20 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-white">Lightning Fast</h3>
                        <p class="text-gray-400">Generate complete proposals in under 10 seconds with our optimized AI pipeline</p>
                    </div>
                    
                    <div class="feature-card bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 border border-slate-700">
                        <div class="w-14 h-14 bg-violet-600/20 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-white">Tailored to You</h3>
                        <p class="text-gray-400">Choose from Professional, Confident, or Short tones to match your personal brand</p>
                    </div>
                    
                    <div class="feature-card bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 border border-slate-700">
                        <div class="w-14 h-14 bg-purple-600/20 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-white">One-Click Copy</h3>
                        <p class="text-gray-400">Copy individual sections or entire proposals instantly with our smart clipboard</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works -->
        <section id="how-it-works" class="py-16 md:py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12 animate-fade-up">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">
                        <span class="bg-gradient-to-r from-indigo-400 to-violet-400 bg-clip-text text-transparent">
                            How It Works
                        </span>
                    </h2>
                    <p class="text-gray-400 text-base md:text-lg">Three simple steps to your next winning proposal</p>
                </div>
                
                <div class="grid md:grid-cols-3 gap-8 relative">
                    <div class="absolute top-1/2 left-0 right-0 h-0.5 bg-gradient-to-r from-indigo-500/50 via-violet-500/50 to-purple-500/50 hidden md:block transform -translate-y-1/2"></div>
                    
                    <div class="relative text-center animate-fade-up" style="animation-delay: 0.1s">
                        <div class="w-20 h-20 bg-gradient-to-br from-indigo-600 to-indigo-700 rounded-full flex items-center justify-center text-3xl font-bold text-white mx-auto mb-4 relative z-10 shadow-xl">
                            1
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-white">Paste Job Description</h3>
                        <p class="text-gray-400">Copy and paste the client's job posting or project brief</p>
                    </div>
                    
                    <div class="relative text-center animate-fade-up" style="animation-delay: 0.2s">
                        <div class="w-20 h-20 bg-gradient-to-br from-violet-600 to-violet-700 rounded-full flex items-center justify-center text-3xl font-bold text-white mx-auto mb-4 relative z-10 shadow-xl">
                            2
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-white">Choose Your Tone</h3>
                        <p class="text-gray-400">Select Professional, Confident, or Short style</p>
                    </div>
                    
                    <div class="relative text-center animate-fade-up" style="animation-delay: 0.3s">
                        <div class="w-20 h-20 bg-gradient-to-br from-purple-600 to-purple-700 rounded-full flex items-center justify-center text-3xl font-bold text-white mx-auto mb-4 relative z-10 shadow-xl">
                            3
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-white">Generate & Copy</h3>
                        <p class="text-gray-400">Get your AI-powered proposal and copy it instantly</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-16 md:py-20 bg-gradient-to-r from-indigo-900/30 to-violet-900/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-4 gap-8 text-center">
                    <div class="animate-fade-up">
                        <div class="text-3xl md:text-4xl lg:text-5xl font-bold text-indigo-400 mb-2">5,000+</div>
                        <div class="text-gray-400 text-sm md:text-base">Active Freelancers</div>
                    </div>
                    <div class="animate-fade-up" style="animation-delay: 0.1s">
                        <div class="text-3xl md:text-4xl lg:text-5xl font-bold text-violet-400 mb-2">$2.5M+</div>
                        <div class="text-gray-400 text-sm md:text-base">Client Projects Won</div>
                    </div>
                    <div class="animate-fade-up" style="animation-delay: 0.2s">
                        <div class="text-3xl md:text-4xl lg:text-5xl font-bold text-purple-400 mb-2">98%</div>
                        <div class="text-gray-400 text-sm md:text-base">Success Rate</div>
                    </div>
                    <div class="animate-fade-up" style="animation-delay: 0.3s">
                        <div class="text-3xl md:text-4xl lg:text-5xl font-bold text-pink-400 mb-2">10s</div>
                        <div class="text-gray-400 text-sm md:text-base">Average Generation Time</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-16 md:py-20">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="bg-gradient-to-br from-indigo-600/20 to-violet-600/20 backdrop-blur-sm rounded-3xl p-8 md:p-12 border border-indigo-500/30 animate-fade-up">
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-4 text-white">
                        Ready to Win More Clients?
                    </h2>
                    <p class="text-gray-300 text-base md:text-lg mb-6">
                        Join thousands of freelancers who use PitchCraft AI to create winning proposals
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="/pitchcraft" class="bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 px-6 md:px-8 py-3 md:py-4 rounded-xl font-semibold transition-all transform hover:scale-105 shadow-xl inline-flex items-center justify-center gap-2 group">
                            Start Free Trial
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                        <button class="border border-slate-600 hover:border-indigo-500 px-6 md:px-8 py-3 md:py-4 rounded-xl font-semibold transition-all hover:bg-slate-800/50">
                            Schedule Demo
                        </button>
                    </div>
                    <p class="text-xs md:text-sm text-gray-500 mt-6">No credit card required · Free forever plan available</p>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="border-t border-slate-800 py-8 md:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-500">
                <p class="text-sm md:text-base">Powered by Laravel AI SDK · PitchCraft AI — Smart proposals for freelancers</p>
                <p class="text-xs md:text-sm mt-2">© 2024 PitchCraft AI. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <script>
        // Particle background generation
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 50;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                
                const size = Math.random() * 4 + 2;
                const left = Math.random() * 100;
                const duration = Math.random() * 15 + 10;
                const delay = Math.random() * 10;
                
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                particle.style.left = `${left}%`;
                particle.style.animationDuration = `${duration}s`;
                particle.style.animationDelay = `${delay}s`;
                particle.style.opacity = Math.random() * 0.3 + 0.1;
                
                particlesContainer.appendChild(particle);
            }
        }
        
        // Initialize particles on load
        createParticles();
        
        // Smooth scroll for navigation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
        
        // Navbar background change on scroll
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.classList.add('bg-slate-900/95', 'shadow-xl');
            } else {
                nav.classList.remove('bg-slate-900/95', 'shadow-xl');
            }
        });
        
        // Intersection Observer for fade-in animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);
        
        document.querySelectorAll('.animate-fade-up, .feature-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.6s ease-out';
            observer.observe(el);
        });
    </script>
</body>
</html>