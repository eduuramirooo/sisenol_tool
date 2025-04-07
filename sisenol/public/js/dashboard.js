function mostrarSeccion(seccion) {
    ['productos', 'instalacion', 'notas'].forEach(id => {
        const div = document.getElementById('seccion-' + id);
        const btn = document.querySelector(`#menu-buttons button[onclick*="${id}"]`);
        const welcome= document.getElementById('welcome-message');
        if (id === seccion) {
            div.classList.remove('hidden');
            btn.classList.remove('bg-white');
            btn.classList.add('bg-[#49A078]');
            welcome.classList.add('hidden');
            const children = div.querySelectorAll('div');
            children.forEach((el, i) => {
                el.style.opacity = 0;
                el.style.transform = 'translateY(20px)';
                el.style.transition = `opacity 400ms ease ${i * 100}ms, transform 400ms ease ${i * 100}ms`;
                setTimeout(() => {
                    el.style.opacity = 1;
                    el.style.transform = 'translateY(0)';
                }, 50);
            });

            setTimeout(() => div.classList.add('opacity-100'), 10);
            div.classList.remove('opacity-0');
        } else {
            div.classList.remove('opacity-100');
            div.classList.add('opacity-0');
            setTimeout(() => div.classList.add('hidden'), 500);
            btn.classList.add('bg-white');  
            btn.classList.remove('bg-[#49A078]');
        }
    });
}

function toggleMenu() {
    const menu = document.getElementById('menu-buttons');
    menu.classList.toggle('hidden');
}

function mostrarPlano(url) {
    const modal = document.getElementById('plano-modal');
    const img = document.getElementById('plano-ampliado');
    img.src = url;
    modal.classList.remove('hidden');
    document.getElementById('main-container').classList.add('blur-sm');
}

function cerrarPlano() {
    const modal = document.getElementById('plano-modal');
    modal.classList.add('hidden');
    document.getElementById('main-container').classList.remove('blur-sm');
}