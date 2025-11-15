    </main>

    <footer class="footer">
        <div class="contenedor">
            <div class="footer-contenido">
                <div class="footer-info">
                    <h3>Construpro</h3>
                    <p>Conectando clientes con profesionales de la construcción de confianza.</p>
                    <div class="redes-sociales">
                        <a href="#" aria-label="Facebook">construpro-de-todos<i class="fab fa-facebook"></i></a>
                        <a href="#" aria-label="Instagram">mi_construpro<i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="Twitter">construpro<i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="LinkedIn">app.construpro<i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
                
                <div class="footer-enlaces">
                    <h4>Enlaces Rápidos</h4>
                    <ul>
                        <li><a href="/index.php">Inicio</a></li>
                        <li><a href="/clientes/buscar_profesionales.php">Buscar Profesionales</a></li>
                        <li><a href="/clientes/login.php">Acceso Clientes</a></li>
                        <li><a href="/profesionales/login.php">Acceso Profesionales</a></li>
                    </ul>
                </div>
                
                <div class="footer-contacto">
                    <h4>Contacto</h4>
                    <p><i class="fas fa-envelope"></i> info@construpro.com</p>
                    <p><i class="fas fa-phone"></i> +54 11 23959404</p>
                    <p><i class="fas fa-map-marker-alt"></i> Buenos Aires, Argentina</p>
                </div>
            </div>
            
            <div class="footer-derechos">
                <p>&copy; <?php echo date('Y'); ?> Construpro - Proyecto final para la carrera de Tecnicatura Universitaria en Programación comisión 4C - UTN.</p>
                <p>Desarrollado por Damian Noble & Nestor Fernandez</p>
            </div>
        </div>
    </footer>

    <script>
        // Menú móvil
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.querySelector('.menu-toggle');
            const navegacion = document.querySelector('.navegacion');
            
            if (menuToggle && navegacion) {
                menuToggle.addEventListener('click', function() {
                    navegacion.classList.toggle('activo');
                    menuToggle.classList.toggle('activo');
                    document.body.classList.toggle('menu-abierto');
                });
                
                // Cerrar menú al hacer clic en un enlace
                const enlacesMenu = document.querySelectorAll('.navegacion a');
                enlacesMenu.forEach(enlace => {
                    enlace.addEventListener('click', function() {
                        navegacion.classList.remove('activo');
                        menuToggle.classList.remove('activo');
                        document.body.classList.remove('menu-abierto');
                    });
                });
            }
            
            // Scroll suave para enlaces internos
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 100,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
