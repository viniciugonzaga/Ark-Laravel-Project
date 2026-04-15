import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


// =============================================
// 1. EFEITO DE SCANNER NO TÍTULO AO PASSAR O MOUSE
// =============================================
document.querySelectorAll('.ark-title').forEach(title => {
    title.addEventListener('mousemove', (e) => {
        const rect = title.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        const centerX = rect.width / 2;
        const centerY = rect.height / 2;
        const rotateX = ((y - centerY) / centerY) * 5; // -5deg a 5deg
        const rotateY = ((x - centerX) / centerX) * 5;
        title.style.transform = `perspective(1000px) rotateX(${-rotateX}deg) rotateY(${rotateY}deg) translateY(-5px)`;
    });
    title.addEventListener('mouseleave', () => {
        title.style.transform = '';
    });
});

// =============================================
// 2. SISTEMA DE PARTÍCULAS DE FUNDO (CANVAS)
// =============================================
function initParticles() {
    const canvas = document.createElement('canvas');
    canvas.id = 'ark-particles';
    canvas.style.position = 'fixed';
    canvas.style.top = '0';
    canvas.style.left = '0';
    canvas.style.width = '100%';
    canvas.style.height = '100%';
    canvas.style.pointerEvents = 'none';
    canvas.style.zIndex = '-1';
    document.body.prepend(canvas);

    const ctx = canvas.getContext('2d');
    let width, height;
    let particles = [];
    const PARTICLE_COUNT = 50;

    function resize() {
        width = window.innerWidth;
        height = window.innerHeight;
        canvas.width = width;
        canvas.height = height;
        initParticlesArray();
    }

    function initParticlesArray() {
        particles = [];
        for (let i = 0; i < PARTICLE_COUNT; i++) {
            particles.push({
                x: Math.random() * width,
                y: Math.random() * height,
                radius: Math.random() * 2 + 1,
                speedX: (Math.random() - 0.5) * 0.5,
                speedY: (Math.random() - 0.5) * 0.5,
                color: `rgba(182, 255, 243, ${Math.random() * 0.3 + 0.1})`
            });
        }
    }

    function draw() {
        ctx.clearRect(0, 0, width, height);
        particles.forEach(p => {
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
            ctx.fillStyle = p.color;
            ctx.fill();

            // Mover
            p.x += p.speedX;
            p.y += p.speedY;

            // Rebotar nas bordas
            if (p.x < 0 || p.x > width) p.speedX *= -1;
            if (p.y < 0 || p.y > height) p.speedY *= -1;
        });
        requestAnimationFrame(draw);
    }

    window.addEventListener('resize', resize);
    resize();
    draw();
}

// Inicia partículas se não estiver em dispositivo móvel (opcional)
if (window.innerWidth > 768) {
    initParticles();
}

// =============================================
// 3. ANIMAÇÃO DE ROLAGEM DO DADO (APERFEIÇOADA)
// =============================================
window.rolarDado = function(tipo = 'd20', callback = null) {
    const overlay = document.getElementById('animacaoDado');
    const resultadoDiv = overlay.querySelector('#dadoResultado') || overlay.querySelector('div:first-child');
    const audio = document.getElementById('somDado');
    
    if (!overlay) return;
    
    overlay.style.display = 'block';
    if (audio) {
        audio.currentTime = 0;
        audio.play().catch(e => console.log('Audio não pôde ser reproduzido'));
    }
    
    let count = 0;
    const maxCount = 15;
    const interval = setInterval(() => {
        const fakeResult = Math.floor(Math.random() * (tipo === 'd20' ? 20 : 6)) + 1;
        resultadoDiv.textContent = `🎲 ${fakeResult}`;
        count++;
        if (count >= maxCount) {
            clearInterval(interval);
            const finalResult = Math.floor(Math.random() * (tipo === 'd20' ? 20 : 6)) + 1;
            resultadoDiv.textContent = `✨ ${finalResult} ✨`;
            resultadoDiv.style.color = '#b6fff3';
            resultadoDiv.style.textShadow = '0 0 15px #00f2ff';
            
            setTimeout(() => {
                overlay.style.display = 'none';
                resultadoDiv.style.color = '';
                resultadoDiv.style.textShadow = '';
                if (callback) callback(finalResult);
            }, 1500);
        }
    }, 80);
};

// =============================================
// 4. DETECÇÃO DE VISIBILIDADE PARA ANIMAÇÕES (INTERSECTION OBSERVER)
// =============================================
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate-visible');
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('.ark-card, .ark-panel, .ark-title').forEach(el => observer.observe(el));
