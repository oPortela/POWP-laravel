<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP Modal - Sistema de Gestão para PMEs</title>
    <meta name="description" content="Sistema completo de gestão empresarial para pequenas e médias empresas">
    <link rel="stylesheet" href="../../public/css/index.css">
    <link rel="stylesheet" href="css/teste-gratis.css">
    <link rel="shortcut icon" href="assets/imagens/favicon-16x16.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <nav class="nav">
                <div class="logo">
                    <div class="logo-icon">P</div>
                    <span class="logo-text">Powp-ERP</span>
                </div>
                
                <div class="nav-links" id="navLinks">
                    <a href="#home">Início</a>
                    <a href="#features">Funcionalidades</a>
                    <a href="#benefits">Benefícios</a>
                    <a href="#testimonials">Depoimentos</a>
                    <a href="#contact">Contato</a>
                </div>

                <div class="nav-buttons" id="navButtons">
                    <button class="btn btn-outline"><a href="login.html">Login</a></button>
                    <button class="btn btn-primary" onclick="testeGratis.openModal()">Teste Grátis</button>
                </div>

                <button class="mobile-menu-btn" id="mobileMenuBtn">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </nav>

            <div class="mobile-menu" id="mobileMenu">
                <a href="#home">Início</a>
                <a href="#features">Funcionalidades</a>
                <a href="#benefits">Benefícios</a>
                <a href="#testimonials">Depoimentos</a>
                <a href="#contact">Contato</a>
                <div class="mobile-buttons">
                    <button class="btn btn-outline" onclick="window.location.href='login.html'">Login</button>
                    <button class="btn btn-primary" onclick="testeGratis.openModal()">Teste Grátis</button>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title">
                        ERP Modal para
                        <span class="text-green">Pequenas e Médias</span>
                        <span>Empresas</span>
                    </h1>
                    <p class="hero-description">
                        Sistema completo de gestão empresarial desenvolvido especialmente para PMEs. 
                        Controle vendas, estoque, financeiro e muito mais em uma única plataforma.
                    </p>
                    
                    <div class="hero-buttons">
                        <button class="btn btn-primary btn-lg" onclick="testeGratis.openModal()">
                            Começar Teste Grátis
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="m9 18 6-6-6-6"/>
                            </svg>
                        </button>
                        <button class="btn btn-outline btn-lg" onclick="window.open('dashboard.html', '_blank')">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <polygon points="5,3 19,12 5,21 5,3"/>
                            </svg>
                            Ver Demonstração
                        </button>
                    </div>

                    <div class="hero-stats">
                        <div class="stat">
                            <div class="stat-number">100+</div>
                            <div class="stat-label">Empresas atendidas</div>
                        </div>
                        <div class="stat">
                            <div class="stat-number">98%</div>
                            <div class="stat-label">Satisfação</div>
                        </div>
                        <div class="stat">
                            <div class="stat-number">24/7</div>
                            <div class="stat-label">Suporte</div>
                        </div>
                    </div>
                </div>

                <div class="hero-image">
                    <div class="dashboard-mockup">
                        <div class="dashboard-header"></div>
                        <div class="dashboard-content">
                            <div class="dashboard-row">
                                <div class="dashboard-item">
                                    <div class="item-label">Dashboard</div>
                                    <div class="item-date">Hoje</div>
                                </div>
                            </div>
                            <div class="dashboard-cards">
                                <div class="card">
                                    <div class="card-label">Vendas Hoje</div>
                                    <div class="card-value">R$ 10.356,23</div>
                                </div>
                                <div class="card">
                                    <div class="card-label">Clientes Ativos</div>
                                    <div class="card-value">744</div>
                                </div>
                            </div>
                            <div class="chart">
                                <div class="chart-bar" style="height: 40%"></div>
                                <div class="chart-bar" style="height: 60%"></div>
                                <div class="chart-bar" style="height: 35%"></div>
                                <div class="chart-bar" style="height: 80%"></div>
                                <div class="chart-bar" style="height: 55%"></div>
                                <div class="chart-bar" style="height: 90%"></div>
                                <div class="chart-bar" style="height: 45%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features">
        <div class="container">
            <div class="section-header">
                <h2>Funcionalidades Completas</h2>
                <p>Tudo que sua empresa precisa para crescer de forma organizada e eficiente, em um sistema integrado e fácil de usar.</p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3>Dashboard Inteligente</h3>
                    <p>Visualize todas as informações importantes do seu negócio em tempo real com gráficos e métricas personalizáveis.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">💰</div>
                    <h3>Gestão Financeira</h3>
                    <p>Controle completo do fluxo de caixa, contas a pagar e receber, relatórios financeiros detalhados.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">📦</div>
                    <h3>Controle de Estoque</h3>
                    <p>Gerencie produtos, fornecedores, entradas e saídas com alertas automáticos de estoque baixo.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">👥</div>
                    <h3>CRM Integrado</h3>
                    <p>Mantenha relacionamento próximo com clientes, histórico de vendas e oportunidades de negócio.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">📄</div>
                    <h3>Relatórios Avançados</h3>
                    <p>Gere relatórios personalizados para tomar decisões baseadas em dados concretos.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🧠</div>
                    <h3>Chat interativo</h3>
                    <p>Faça perguntas a nossa IA que trará resultados e insights valiosos para seu negócio.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon"><img src="assets/imagens/Amazon_Web_Services_Logo.svg.png" alt=""></div>
                    <h3>Integração com AWS</h3>
                    <p>Integração nativa com AWS, com o Bedrock e demais serviços.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">⚙️</div>
                    <h3>Automação</h3>
                    <p>Automatize processos repetitivos e economize tempo para focar no crescimento do negócio.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🔒</div>
                    <h3>Segurança Total</h3>
                    <p>Seus dados protegidos com criptografia avançada e backups automáticos diários.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">☁️</div>
                    <h3>Acesso na Nuvem</h3>
                    <p>Acesse de qualquer lugar, a qualquer hora, em qualquer dispositivo com internet.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section id="benefits" class="benefits">
        <div class="container">
            <div class="section-header">
                <h2>Por que Escolher o ERP Modal?</h2>
                <p>Desenvolvido especificamente para pequenas e médias empresas, oferecemos a solução ideal para seu crescimento.</p>
            </div>

            <div class="benefits-content">
                <div class="benefits-list">
                    <div class="benefit-item">
                        <div class="benefit-icon">📈</div>
                        <div class="benefit-text">
                            <h3>Aumente sua Produtividade</h3>
                            <p>Automatize tarefas repetitivas e ganhe até 40% mais tempo para focar no crescimento.</p>
                            <div class="benefit-stat">+40% produtividade</div>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon">⏰</div>
                        <div class="benefit-text">
                            <h3>Economize Tempo</h3>
                            <p>Processos integrados eliminam retrabalho e aceleram suas operações diárias.</p>
                            <div class="benefit-stat">8h economizadas/semana</div>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon">⚡</div>
                        <div class="benefit-text">
                            <h3>Decisões Mais Rápidas</h3>
                            <p>Dados em tempo real para tomar decisões assertivas e estratégicas.</p>
                            <div class="benefit-stat">Decisões 3x mais rápidas</div>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon">💲</div>
                        <div class="benefit-text">
                            <h3>Redução de Custos</h3>
                            <p>Dados armazenados na nuvem, basta ter acesso a internet para utilizar.</p>
                            <div class="benefit-stat">-80% custo</div>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon">✅</div>
                        <div class="benefit-text">
                            <h3>Redução de Erros</h3>
                            <p>Controles automáticos e validações reduzem erros operacionais significativamente.</p>
                            <div class="benefit-stat">-90% erros</div>
                        </div>
                    </div>
                </div>

                <div class="benefits-card">
                    <h3>Diferenciais do ERP Modal</h3>
                    <div class="benefits-checklist">
                        <div class="checklist-item">Interface intuitiva e fácil de usar</div>
                        <div class="checklist-item">Compre o módulo que desejar</div>
                        <div class="checklist-item">Implementação rápida em até 7 dias</div>
                        <div class="checklist-item">Suporte técnico especializado 24/7</div>
                        <div class="checklist-item">Preço acessível para PMEs</div>
                        <div class="checklist-item">Personalização sem custos extras</div>
                        <div class="checklist-item">Sem custo com hardware</div>
                        <div class="checklist-item">Atualizações automáticas incluídas</div>
                        <div class="checklist-item">Treinamento completo da equipe</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials">
        <div class="container">
            <div class="section-header">
                <h2>O que Nossos Clientes Dizem</h2>
                <p>Mais de 100 empresas já transformaram sua gestão com o ERP Modal. Veja alguns depoimentos reais de nossos clientes satisfeitos.</p>
            </div>

            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="stars">★★★★★</div>
                    <p>"O ERP Modal transformou nossa gestão. Agora tenho controle total do estoque e financeiro. Recomendo para qualquer empresário que quer crescer de forma organizada."</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">MS</div>
                        <div class="author-info">
                            <div class="author-name">Matheus Marques</div>
                            <div class="author-company">Loja Bella Moda</div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="stars">★★★★★</div>
                    <p>"Implementação foi super rápida e o suporte é excepcional. Em 3 meses já vimos 30% de aumento na produtividade da equipe."</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">JS</div>
                        <div class="author-info">
                            <div class="author-name">Pedro Henrique</div>
                            <div class="author-company">Distribuidora São Paulo</div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="stars">★★★★★</div>
                    <p>"Sistema muito fácil de usar. Minha equipe aprendeu rapidamente e agora nossos processos são muito mais eficientes."</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">AC</div>
                        <div class="author-info">
                            <div class="author-name">João Luccas</div>
                            <div class="author-company">Padaria do Bairro</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <div class="cta-content">
                <h2>Pronto para Transformar sua Empresa?</h2>
                <p>Junte-se a mais de 100 empresas que já modernizaram sua gestão. Comece hoje mesmo com 30 dias grátis, sem compromisso.</p>

                <div class="cta-buttons">
                    <button class="btn btn-secondary btn-lg" onclick="testeGratis.openModal()">
                        Começar Teste Grátis Agora
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="m9 18 6-6-6-6"/>
                        </svg>
                    </button>
                    <button class="btn btn-outline-white btn-lg" onclick="window.open('https://wa.me/5562999999999?text=Olá! Gostaria de falar com um especialista sobre o ERP Modal', '_blank')">
                        Falar com Especialista
                    </button>
                </div>

                <div class="cta-features">
                    <div class="cta-feature">
                        <span class="check">✓</span>
                        <span>30 dias grátis</span>
                    </div>
                    <div class="cta-feature">
                        <span class="check">✓</span>
                        <span>Sem taxa de setup</span>
                    </div>
                    <div class="cta-feature">
                        <span class="check">✓</span>
                        <span>Suporte incluído</span>
                    </div>
                    <div class="cta-feature">
                        <span class="check">✓</span>
                        <span>Cancele a qualquer momento</span>
                    </div>
                    <div class="cta-feature">
                        <span class="check">✓</span>
                        <span>Dados na nuvem</span>
                    </div>
                    <div class="cta-feature">
                        <span class="check">✓</span>
                        <span>Facilidade na sua utilização</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <div class="logo-icon">P</div>
                        <span class="logo-text">ERP Modal</span>
                    </div>
                    <p>Sistema de gestão completo para pequenas e médias empresas. Simplifique seus processos e acelere seu crescimento.</p>
                </div>

                <div class="footer-section">
                    <h3>Produto</h3>
                    <ul>
                        <li><a href="#features">Funcionalidades</a></li>
                        <li><a href="#benefits">Benefícios</a></li>
                        <li><a href="#">Preços</a></li>
                        <li><a href="#">Integrações</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Suporte</h3>
                    <ul>
                        <li><a href="#">Central de Ajuda</a></li>
                        <li><a href="#">Documentação</a></li>
                        <li><a href="#">Treinamentos</a></li>
                        <li><a href="#">Status do Sistema</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Contato</h3>
                    <div class="contact-info">
                        <div class="contact-item">
                            <span class="contact-icon">📞</span>
                            <span>(62) 9999-9999</span>
                        </div>
                        <div class="contact-item">
                            <span class="contact-icon">📧</span>
                            <span>comercial@powp.com.br</span>
                        </div>
                        <div class="contact-item">
                            <span class="contact-icon">📍</span>
                            <span>Anápolis, GO</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p>© 2025 Powp-ERP. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Modal de Teste Grátis -->
    <div id="testeGratisModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>🚀 Teste Grátis por 30 Dias</h2>
                <span class="close" id="closeModal">&times;</span>
            </div>
            
            <div class="modal-body">
                <div class="benefits-preview">
                    <div class="benefit-item">
                        <span class="check">✓</span>
                        <span>Acesso completo ao sistema</span>
                    </div>
                    <div class="benefit-item">
                        <span class="check">✓</span>
                        <span>Dados de exemplo incluídos</span>
                    </div>
                    <div class="benefit-item">
                        <span class="check">✓</span>
                        <span>Suporte por WhatsApp</span>
                    </div>
                    <div class="benefit-item">
                        <span class="check">✓</span>
                        <span>Sem cartão de crédito</span>
                    </div>
                </div>

                <form id="testeGratisForm" class="teste-form">
                    <div class="form-group">
                        <label for="nomeEmpresa">Nome da Empresa *</label>
                        <input type="text" id="nomeEmpresa" name="nomeEmpresa" required>
                    </div>

                    <div class="form-group">
                        <label for="nomeResponsavel">Seu Nome *</label>
                        <input type="text" id="nomeResponsavel" name="nomeResponsavel" required>
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail *</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="telefone">WhatsApp *</label>
                        <input type="tel" id="telefone" name="telefone" placeholder="(62) 99999-9999" required>
                    </div>

                    <div class="form-group">
                        <label for="segmento">Segmento da Empresa</label>
                        <select id="segmento" name="segmento">
                            <option value="">Selecione...</option>
                            <option value="comercio">Comércio</option>
                            <option value="servicos">Serviços</option>
                            <option value="industria">Indústria</option>
                            <option value="distribuicao">Distribuição</option>
                            <option value="outros">Outros</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="funcionarios">Número de Funcionários</label>
                        <select id="funcionarios" name="funcionarios">
                            <option value="">Selecione...</option>
                            <option value="1-5">1 a 5</option>
                            <option value="6-20">6 a 20</option>
                            <option value="21-50">21 a 50</option>
                            <option value="51-100">51 a 100</option>
                            <option value="100+">Mais de 100</option>
                        </select>
                    </div>

                    <div class="form-group checkbox-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="termos" name="termos" required>
                            <span class="checkmark"></span>
                            Aceito os <a href="#" target="_blank">termos de uso</a> e <a href="#" target="_blank">política de privacidade</a>
                        </label>
                    </div>

                    <div class="form-group checkbox-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="newsletter" name="newsletter">
                            <span class="checkmark"></span>
                            Quero receber dicas e novidades por e-mail
                        </label>
                    </div>

                    <button type="submit" class="btn-submit" id="btnSubmit">
                        <span class="btn-text">Iniciar Teste Grátis</span>
                        <div class="loading" id="loading" style="display: none;">
                            <div class="spinner"></div>
                        </div>
                    </button>
                </form>

                <div class="success-message" id="successMessage" style="display: none;">
                    <div class="success-icon">🎉</div>
                    <h3>Teste Grátis Ativado!</h3>
                    <p>Enviamos suas credenciais de acesso por e-mail.</p>
                    <div class="access-info">
                        <p><strong>Seu acesso:</strong></p>
                        <p>Usuário: <span id="usuarioDemo"></span></p>
                        <p>Senha: <span id="senhaDemo"></span></p>
                    </div>
                    <button class="btn-access" onclick="window.open('dashboard.html', '_blank')">
                        Acessar Sistema Agora
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="js/index.js"></script>
    <script src="js/teste-gratis.js"></script>
</body>
</html>