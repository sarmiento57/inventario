const formularios_ajax = document.querySelectorAll('.FormularioAjax');

function enviar_formulario_ajax(e) {//Funcion para enviar los formularios por ajax
    e.preventDefault();//Evita que se recargue la pagina
    let enviar=confirm('¿Estas seguro de enviar este formulario?');
    if(enviar==true){
        let data = new FormData(this);//Obtiene los datos del formulario
        let method = this.getAttribute('method');//Obtiene el metodo del formulario
        let action = this.getAttribute('action');//Obtiene la accion del formulario
        let encabezado = new Headers();
        let config = {//Configuracion de la peticion que se va a enviar
            method: method, //Metodo de envio
            headers: encabezado, //Encabezado
            mode: 'cors', //Modo de envio
            cache: 'no-cache', //Cache
            body: data //Datos a enviar
        };
        //api fetch de javascript
        fetch(action, config)//Envia la peticion al servidor
        .then(respuesta => respuesta.text()) //Obtiene la respuesta del servidor
        .then(respuesta =>{ //Obtiene la respuesta del servidor
            let contenedor=document.querySelector('.form-reset');//Obtiene el contenedor de mensaje
            contenedor.innerHTML=respuesta;//Muestra el mensaje
        })
    }
}

formularios_ajax.forEach(formularios => {//Recorre los formularios
    formularios.addEventListener('submit', enviar_formulario_ajax)//Agrega el evento submit a los formularios
});