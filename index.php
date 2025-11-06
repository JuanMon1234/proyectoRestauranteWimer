<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sabor de Hogar sena Mundo - Restaurante Internacional</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilo/css/styles.css">
</head>
<body>
    <header id="home">
        <div class="logo">Sabor de Hogar</div>
        <div class="slogan">Una experiencia gastronómica internacional</div>
        <div class="btn-container">
            <button id="reservationBtn" class="btn">Reservar Mesa</button>
            <button id="menuBtn" class="btn btn-outline">Ver Menú</button>
        </div>
    </header>
    
    <nav>
        <ul>
            <li><a href="#home">Inicio</a></li>
            <li><a href="#about">Nosotros</a></li>
            <li><a href="#menu">Menú</a></li>
            <li><a href="#cuisines">Especialidades</a></li>
            <li><a href="#testimonials">Testimonios</a></li>
            <li><a href="#contact">Contacto</a></li>
            <li><a href="login.php">Inicio sesión</a></li>
        </ul>
    </nav>
    
    <section id="about" class="container">
        <h2>Sobre Nosotros</h2>
        <p style="text-align: center; max-width: 800px; margin: 0 auto 2rem; line-height: 1.8; font-size: 1.1rem;">
            En Sabores del Mundo, nos apasiona ofrecer una experiencia culinaria única que transporta a nuestros comensales a través de los sabores más auténticos de diferentes culturas. Nuestros chefs, expertos en cocina internacional, preparan cada platillo con ingredientes frescos y técnicas tradicionales para ofrecerte un viaje gastronómico inolvidable.
        </p>
        <div style="text-align: center;">
            <a href="#cuisines" class="btn">Descubre Nuestras Especialidades</a>
        </div>
    </section>
    
    <section id="cuisines" style="background-color: var(--light);">
        <div class="container">
            <h2>Nuestras Especialidades</h2>
            <div class="cuisines">
                <div class="cuisine-card">
                    <div class="cuisine-img" style="background-image: url('https://images.unsplash.com/photo-1546069901-ba9599a7e63c');"></div>
                    <div class="cuisine-content">
                        <h3>Cocina Italiana</h3>
                        <p>Auténticas pastas al dente, risottos cremosos y pizzas horneadas en leña, preparadas con ingredientes importados directamente de Italia.</p>
                        <a href="#menu" class="btn" style="display: inline-block; margin-top: 1rem; padding: 0.6rem 1.5rem; font-size: 0.9rem;">Ver Platos</a>
                    </div>
                </div>
                
                <div class="cuisine-card">
                    <div class="cuisine-img" style="background-image: url('https://images.unsplash.com/photo-1544025162-d76694265947');"></div>
                    <div class="cuisine-content">
                        <h3>Cocina Japonesa</h3>
                        <p>Sushi fresco preparado diariamente por nuestros chefs japoneses, tempura crujiente y deliciosos platos de ramen tradicional.</p>
                        <a href="#menu" class="btn" style="display: inline-block; margin-top: 1rem; padding: 0.6rem 1.5rem; font-size: 0.9rem;">Ver Platos</a>
                    </div>
                </div>
                
                <div class="cuisine-card">
                    <div class="cuisine-img" style="background-image: url('https://images.unsplash.com/photo-1536304993881-ff6e9eefa2a6');"></div>
                    <div class="cuisine-content">
                        <h3>Cocina Mexicana</h3>
                        <p>Sabores picantes y auténticos de México, desde tacos al pastor hasta mole poblano, preparados con recetas tradicionales.</p>
                        <a href="#menu" class="btn" style="display: inline-block; margin-top: 1rem; padding: 0.6rem 1.5rem; font-size: 0.9rem;">Ver Platos</a>
                    </div>
                </div>
                
                <div class="cuisine-card">
                    <div class="cuisine-img" style="background-image: url('https://images.unsplash.com/photo-1547592180-85f173990554');"></div>
                    <div class="cuisine-content">
                        <h3>Cocina Mediterránea</h3>
                        <p>Platos saludables y llenos de sabor con aceite de oliva extra virgen, hierbas frescas y los mejores ingredientes de la región.</p>
                        <a href="#menu" class="btn" style="display: inline-block; margin-top: 1rem; padding: 0.6rem 1.5rem; font-size: 0.9rem;">Ver Platos</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section id="menu" class="container">
        <h2>Destacados del Menú</h2>
        <div class="menu-highlight">
            <div class="menu-item">
                <h3>Pasta Carbonara Original <span class="price">$18.900</span></h3>
                <p>Pasta con salsa cremosa de huevo, queso pecorino, panceta y pimienta negra.</p>
            </div>
            
            <div class="menu-item">
                <h3>Sushi Omakase <span class="price">$28.900</span></h3>
                <p>Selección del chef con los cortes más frescos del día, incluye 12 piezas.</p>
            </div>
            
            <div class="menu-item">
                <h3>Tacos de Birria <span class="price">$14.900</span></h3>
                <p>Tres tacos de birria tradicional con consomé, cebolla, cilantro y limón.</p>
            </div>
            
            <div class="menu-item">
                <h3>Paella Valenciana <span class="price">$24.900</span></h3>
                <p>Arroz con azafrán, mariscos, pollo y conejo, preparado en sartén tradicional.</p>
            </div>
            
            <div class="menu-item">
                <h3>Ensalada Griega <span class="price">$12.900</span></h3>
                <p>Tomate, pepino, cebolla roja, aceitunas kalamata y queso feta con aderezo de limón.</p>
            </div>
            
            <div class="menu-item">
                <h3>Tiramisú Clásico <span class="price">$8.900</span></h3>
                <p>Postre italiano con capas de bizcocho empapado en café y crema de mascarpone.</p>
            </div>
        </div>
        
        <div style="text-align: center; margin-top: 3rem;">
            <button id="fullMenuBtn" class="btn">Ver Menú Completo</button>
        </div>
    </section>
    
    <section id="testimonials" style="background-color: var(--light);">
        <div class="container">
            <h2>Lo Que Dicen Nuestros Clientes</h2>
            <div class="testimonials">
                <div class="testimonial">
                    <div class="testimonial-text">
                        "La mejor experiencia gastronómica que he tenido. Cada plato es una obra de arte y los sabores son increíblemente auténticos. El servicio es impecable y el ambiente es perfecto para una cena especial."
                    </div>
                    <div class="testimonial-author">- María González</div>
                    <div class="rating">
                        ★★★★★
                    </div>
                </div>
                
                <div class="testimonial">
                    <div class="testimonial-text">
                        "El sushi aquí es mejor que en muchos lugares de Tokio que he visitado. Frescura y presentación impecables. Los chefs realmente saben lo que hacen y se nota en cada bocado."
                    </div>
                    <div class="testimonial-author">- Carlos Tanaka</div>
                    <div class="rating">
                        ★★★★★
                    </div>
                </div>
                
                <div class="testimonial">
                    <div class="testimonial-text">
                        "Ambiente acogedor, servicio excepcional y una variedad de opciones que satisfacen a toda la familia. Hemos celebrado varios cumpleaños aquí y siempre es una experiencia memorable. ¡Nuestro lugar favorito!"
                    </div>
                    <div class="testimonial-author">- Familia Rodríguez</div>
                    <div class="rating">
                        ★★★★☆
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section id="reservations" class="container">
        <h2>Horario y Ubicación</h2>
        <div class="reservation-info">
            <p>Visítanos y disfruta de una experiencia gastronómica inolvidable en un ambiente cálido y acogedor.</p>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-top: 2rem;">
                <div>
                    <h3 style="color: var(--dark); margin-bottom: 1rem; font-family: 'Playfair Display', serif;">Horario</h3>
                    <p><strong>Lunes - Viernes:</strong> 11:00 am - 10:00 pm</p>
                    <p><strong>Sábados - Domingos:</strong> 10:00 am - 11:00 pm</p>
                </div>
                
                <div>
                    <h3 style="color: var(--dark); margin-bottom: 1rem; font-family: 'Playfair Display', serif;">Ubicación</h3>
                    <p><strong>Dirección:</strong> Cra 9#71N-60,La Paz </p>
                    <p><strong>Ciudad:</strong> Ciudad Popayan</p>
                </div>
            </div>
        </div>
    </section>
    
    <section id="contact" style="background-color: var(--dark); color: white;">
        <div class="container">
            <h2 style="color: white;">Contáctanos</h2>
            <div class="contact-methods">
                <div class="contact-card">
                    <i class="fas fa-phone-alt"></i>
                    <h3>Celular</h3>
                    <p>+57 3216975589</p>
                    <p>Horario de atención: 10am - 8pm</p>
                </div>
                
                <div class="contact-card">
                    <i class="fas fa-envelope"></i>
                    <h3>Correo</h3>
                    <p>saborhogarsena@sena.edu.co</p>
                    <p>reservas@sena.edu.co</p>
                </div>
                
                <div class="contact-card">
                    <i class="fab fa-whatsapp"></i>
                    <h3>WhatsApp</h3>
                    <p>+57 3216975589</p>
                    <p>Atención inmediata</p>
                </div>
            </div>
        </div>
    </section>
    
    <footer>
        <div class="footer-logo">Sabor Hogar Sena</div>
        <div class="social-icons">
            <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="#" aria-label="Tripadvisor"><i class="fab fa-tripadvisor"></i></a>

        </div>
        <div class="contact-info">
            <div>
                <i class="fas fa-map-marker-alt"></i>
                <p>Cra 9#71N-60,La Paz</p>
            </div>
            <div>
                <i class="fas fa-phone"></i>
                <p>+57 3216975589</p>
            </div>
            <div>
                <i class="fas fa-envelope"></i>
                <p>reservas@sena.edu.co</p>
            </div>
        </div>
        <div class="copyright">
            &copy; 2025 Sabor Hogar Sena. Todos los derechos reservados.
        </div>
    </footer>
    
    <!-- Modal para Reservaciones -->
    <div id="reservationModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2 class="modal-title">Reserva tu Mesa</h2>
            <div class="modal-body">
                <p>Para reservar una mesa en nuestro restaurante, puedes contactarnos por cualquiera de los siguientes métodos:</p>
                
                <div class="reservation-methods">
                    <div class="reservation-method">
                        <i class="fas fa-phone-alt"></i>
                        <h3>Por Teléfono</h3>
                        <p>Llámanos al:</p>
                        <p style="font-weight: bold; font-size: 1.2rem; color: var(--dark);">+57 3216975589</p>
                        <p>Horario de reservas: 10am - 8pm</p>
                    </div>
                    
                    <div class="reservation-method">
                        <i class="fas fa-envelope"></i>
                        <h3>Por Email</h3>
                        <p>Envía un correo a:</p>
                        <p style="font-weight: bold; font-size: 1.2rem; color: var(--dark);">reservas@sena.edu.co</p>
                        <p>Incluye fecha, hora y número de personas</p>
                    </div>
                    
                    <div class="reservation-method">
                        <i class="fab fa-whatsapp"></i>
                        <h3>Por WhatsApp</h3>
                        <p>Envía un mensaje al:</p>
                        <p style="font-weight: bold; font-size: 1.2rem; color: var(--dark);">+57 3216975589</p>
                        <p>Reservas instantáneas 24/7</p>
                    </div>
                </div>
                
                <div style="margin-top: 2rem; background-color: var(--secondary); padding: 1.5rem; border-radius: 10px;">
                    <h3 style="color: var(--dark); margin-bottom: 1rem;">Política de Reservaciones</h3>
                    <ul style="text-align: left; padding-left: 1.5rem;">
                        <li style="margin-bottom: 0.5rem;">Las reservas se mantienen por 15 minutos después de la hora acordada</li>
                        <li style="margin-bottom: 0.5rem;">Grupos de 6+ personas requieren depósito del 20%</li>
                        <li style="margin-bottom: 0.5rem;">Cancelaciones con 24 horas de anticipación</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal para Menú Completo -->
    <div id="menuModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2 class="modal-title">Menú Completo</h2>
            <div class="modal-body">
                <div class="menu-category">
                    <h3>Entradas</h3>
                    <div class="menu-item-modal">
                        <div>
                            <div class="item-name">Bruschetta Clásica</div>
                            <div class="item-description">Pan toscano con tomate fresco, albahaca y aceite de oliva</div>
                        </div>
                        <div class="price">$9.900</div>
                    </div>
                    <div class="menu-item-modal">
                        <div>
                            <div class="item-name">Guacamole Tradicional</div>
                            <div class="item-description">Preparado en molcajete con aguacate, tomate, cebolla y cilantro</div>
                        </div>
                        <div class="price">$11.900</div>
                    </div>
                    <div class="menu-item-modal">
                        <div>
                            <div class="item-name">Edamame</div>
                            <div class="item-description">Vainas de soja con sal marina</div>
                        </div>
                        <div class="price">$7.900</div>
                    </div>
                </div>
                
                <div class="menu-category">
                    <h3>Platos Principales</h3>
                    <div class="menu-item-modal">
                        <div>
                            <div class="item-name">Lasagna Bolognesa</div>
                            <div class="item-description">Capas de pasta con carne, salsa bolognesa y bechamel</div>
                        </div>
                        <div class="price">$19.900</div>
                    </div>
                    <div class="menu-item-modal">
                        <div>
                            <div class="item-name">Parrillada de Carnes</div>
                            <div class="item-description">Cortes selectos con chimichurri y guarniciones</div>
                        </div>
                        <div class="price">$26.900</div>
                    </div>
                    <div class="menu-item-modal">
                        <div>
                            <div class="item-name">Poke Bowl Hawaino</div>
                            <div class="item-description">Atún fresco, arroz, aguacate, edamame y salsa especial</div>
                        </div>
                        <div class="price">$18.900</div>
                    </div>
                </div>
                
                <div class="menu-category">
                    <h3>Postres</h3>
                    <div class="menu-item-modal">
                        <div>
                            <div class="item-name">Tiramisú Clásico</div>
                            <div class="item-description">Capas de bizcocho empapado en café y crema de mascarpone</div>
                        </div>
                        <div class="price">$8.900</div>
                    </div>
                    <div class="menu-item-modal">
                        <div>
                            <div class="item-name">Churros con Chocolate</div>
                            <div class="item-description">Crujientes churros con chocolate caliente espeso</div>
                        </div>
                        <div class="price">$7.900</div>
                    </div>
                    <div class="menu-item-modal">
                        <div>
                            <div class="item-name">Mochi Ice Cream</div>
                            <div class="item-description">Helado japonés envuelto en pasta de arroz (3 piezas)</div>
                        </div>
                        <div class="price">$6.900</div>
                    </div>
                </div>
                
                <div style="margin-top: 2rem; text-align: center;">
                    <p>¿Tienes alguna alergia o restricción alimenticia? Nuestro personal estará encantado de ayudarte.</p>
                </div>
            </div>
        </div>
    </div>
<script src="estilo/js/index.js"></script>

</body>
</html>