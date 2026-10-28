<?php 
// session_register('fun','user','cargo','dep','sid');
?>

<style type="text/css">
.panel__content_hoy {
    padding: 30px;
    border-radius: 12px;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    max-width: 700px;
    margin: 20px auto;
    transition: all 0.3s ease;
}

/* Modo Claro: Panel y Card */
html[data-theme="light"] .panel__content_hoy,
:root:not([data-theme="dark"]) .panel__content_hoy {
    background-color: #ffffff !important;
    color: #0f172a !important;
    border: 1px solid #e2e8f0 !important;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06) !important;
}

html[data-theme="light"] .welcome-header,
:root:not([data-theme="dark"]) .welcome-header {
    border-bottom: 1px solid #e2e8f0 !important;
}

html[data-theme="light"] .welcome-header h2,
:root:not([data-theme="dark"]) .welcome-header h2 {
    color: #800020 !important;
}

html[data-theme="light"] .welcome-header h1,
:root:not([data-theme="dark"]) .welcome-header h1 {
    color: #0f172a !important;
}

html[data-theme="light"] .profile-card,
:root:not([data-theme="dark"]) .profile-card {
    background: #f8fafc !important;
    border: 1px solid #e2e8f0 !important;
}

html[data-theme="light"] .profile-avatar-container img,
:root:not([data-theme="dark"]) .profile-avatar-container img {
    border: 3px solid #800020 !important;
    box-shadow: 0 0 15px rgba(128, 0, 32, 0.25) !important;
    background-color: #ffffff !important;
}

html[data-theme="light"] .info-row,
:root:not([data-theme="dark"]) .info-row {
    border-bottom: 1px solid #e2e8f0 !important;
}

html[data-theme="light"] .info-label,
:root:not([data-theme="dark"]) .info-label {
    color: #64748b !important;
}

html[data-theme="light"] .info-value,
:root:not([data-theme="dark"]) .info-value {
    color: #0f172a !important;
    font-weight: 600 !important;
}

/* Modo Oscuro: Panel y Card */
html[data-theme="dark"] .panel__content_hoy {
    background-color: #1e293b !important;
    color: #f8fafc !important;
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2) !important;
}

html[data-theme="dark"] .welcome-header {
    border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
}

html[data-theme="dark"] .welcome-header h2 {
    color: #f59e0b !important;
}

html[data-theme="dark"] .welcome-header h1 {
    color: #f8fafc !important;
}

html[data-theme="dark"] .profile-card {
    background: rgba(15, 23, 42, 0.4) !important;
    border: 1px solid rgba(255, 255, 255, 0.05) !important;
}

html[data-theme="dark"] .profile-avatar-container img {
    border: 3px solid #be123c !important;
    box-shadow: 0 0 15px rgba(190, 18, 60, 0.35) !important;
    background-color: #0f172a !important;
}

html[data-theme="dark"] .info-row {
    border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
}

html[data-theme="dark"] .info-label {
    color: #94a3b8 !important;
}

html[data-theme="dark"] .info-value {
    color: #f8fafc !important;
}

.welcome-header {
    text-align: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
}

.welcome-header h2 {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.welcome-header h1 {
    font-size: 24px;
    font-weight: 800;
}

.profile-card {
    display: flex;
    align-items: center;
    border-radius: 8px;
    padding: 24px;
    gap: 24px;
}

.profile-avatar-container {
    flex: 0 0 130px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.profile-avatar-container img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
}

.profile-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.info-row {
    display: flex;
    padding-bottom: 8px;
}

.info-row:last-child {
    border-bottom: none !important;
    padding-bottom: 0;
}

.info-label {
    flex: 0 0 100px;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 11px;
    letter-spacing: 0.5px;
}

.info-value {
    flex: 1;
    font-size: 14px;
}
</style>


<div class="panel__content">
    <div class="panel__content_hoy">
        <div class="welcome-header">
            <h2>Sistema de Correspondencia</h2>
            <h1>¡Bienvenido al SIGAPO!</h1>
        </div>

        <div class="profile-card">
            <div class="profile-avatar-container">
                <img src="perfiles/fotos/<?php //echo $_SESSION['user']; ?>default_avatar013.jpg" alt="Foto de perfil" />
            </div>
            
            <div class="profile-info">
                <div class="info-row">
                    <span class="info-label">Usuario</span>
                    <span class="info-value"><?php echo htmlentities($_SESSION['fun']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Cargo</span>
                    <span class="info-value"><?php echo htmlentities($_SESSION['cargo']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Unidad</span>
                    <span class="info-value"><?php echo $_SESSION['dep']; ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
