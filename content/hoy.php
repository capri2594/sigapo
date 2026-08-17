<?php 
// session_register('fun','user','cargo','dep','sid');
?>
<style type="text/css">
.panel__content_hoy {
    background-color: #1e293b;
    color: #f8fafc;
    padding: 30px;
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    max-width: 700px;
    margin: 20px auto;
}

.welcome-header {
    text-align: center;
    margin-bottom: 30px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    padding-bottom: 20px;
}

.welcome-header h2 {
    font-size: 18px;
    font-weight: 600;
    color: #f59e0b;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.welcome-header h1 {
    font-size: 24px;
    font-weight: 700;
    color: #f8fafc;
}

.profile-card {
    display: flex;
    align-items: center;
    background: rgba(15, 23, 42, 0.4);
    border: 1px solid rgba(255, 255, 255, 0.05);
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
    border: 3px solid #2563eb;
    box-shadow: 0 0 15px rgba(37, 99, 235, 0.3);
    object-fit: cover;
    background-color: #0f172a;
}

.profile-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.info-row {
    display: flex;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    padding-bottom: 8px;
}

.info-row:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.info-label {
    flex: 0 0 100px;
    font-weight: 600;
    color: #94a3b8;
    text-transform: uppercase;
    font-size: 11px;
    letter-spacing: 0.5px;
}

.info-value {
    flex: 1;
    font-size: 14px;
    color: #f8fafc;
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
