<div class="container is-fluid mb-6">
    <h1 class="title">Usuarios</h1>
    <h1 class="subtitle">Nuevo usuario</h1>
</div>

<div class="container pb-6 pt-6">
    <div class="form-reset mb-6 mt-6"> 
    </div>

    <form action="./php/usuario_guardar.php" method="POST" autocomplete="off" class="FormularioAjax">
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Nombres</label>
                    <input class="input" type="text" name="usuario_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ]{3,40}" maxlength="40" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Apellidos</label>
                    <input class="input" type="text" name="usuario_apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ]{3,40}" maxlength="40" required>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Usuario</label>
                    <input class="input" type="text" name="usuario_usuario" pattern="[a-zA-Z0-9]{4,28}" maxlength="20" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Email</label>
                    <input class="input" type="email" name="usuario_email" maxlength="70">
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Clave</label>
                    <input class="input" type="password" name="usuario_clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
                </div>
            </div>
            <div class="column">
		    	<div class="control">
					<label>Repetir clave</label>
				  	<input class="input" type="password" name="usuario_clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required >
				</div>
		  	</div>
        </div>
        <p class="has-text-centered">
            <button class="button is-info is-rounded" type="submit">Guardar</button>
        </p>
    </form>
</div>

