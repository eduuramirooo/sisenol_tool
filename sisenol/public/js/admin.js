function mostrarSeccion(seccion) {
    const secciones = ['usuarios', 'productos', 'proyectos', 'notas'];
    secciones.forEach(id => {
        const div = document.getElementById('seccion-' + id);
        const btn = document.querySelector(`#menu-buttons button[onclick*="${id}"]`);
        if (div) {
            if (id === seccion) {
                div.classList.remove('hidden');
                setTimeout(() => {
                    div.classList.remove('opacity-0');
                    div.classList.add('opacity-100');
                }, 10);
                btn.classList.add('bg-[#49A078]');
                btn.classList.remove('bg-white');
            } else {
                div.classList.remove('opacity-100');
                div.classList.add('opacity-0');
                setTimeout(() => div.classList.add('hidden'), 300);
                btn.classList.remove('bg-[#49A078]');
                btn.classList.add('bg-white');
            }
        }
    });
}

function toggleLayout(id) {
    const container = document.getElementById(id);
    if (container.classList.contains('md:grid-cols-1')) {
        container.classList.remove('md:grid-cols-1');
        container.classList.add('md:grid-cols-3');
    } else {
        container.classList.remove('md:grid-cols-3');
        container.classList.add('md:grid-cols-1');
    }
}



function toggleMenu() {
    const menu = document.getElementById('menu-buttons');
    menu.classList.toggle('hidden');
}
document.addEventListener('DOMContentLoaded', () => {
    mostrarSeccion('usuarios');
    const tabla = document.querySelector('table');
    tabla.classList.add('opacity-0');
    setTimeout(() => tabla.classList.remove('opacity-0'), 100);
});
