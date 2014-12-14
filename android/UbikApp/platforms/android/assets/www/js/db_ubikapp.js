//<script src="db_ubikapp.js" type="text/javascript" charset="utf-8"></script>
//$(function(){ 
	
	var localDBUbikApp; //= {
	var UbikAppDB = null;
	
	function init() {
			
			this.initDatabase();

            
            //this.dropTables();
            //this.createTables();
            //this.insertInicial();
			
	}
	
	
	function incializa(){

	    this.dropTables();
        this.createTables();
        this.insertInicial();
	    
	}
	
	
	function initDatabase() {
			try {
			    if (!window.openDatabase) {
			        alert('BDD UbikApp no soportado por dispositivo');
			    } else {
			        var shortName = 'UbikAppDB',
			        	version = '1.0',
						displayName = 'UbikAppDB',
						maxSize = 1024*1024;

			        UbikAppDB = openDatabase(shortName, version, displayName, maxSize);

		            this.selectAll();
		            this.selectNotificacion();
		            this.selectUsadas();
		            this.selectCategorias();

			    }
			} catch(e) {
			    if (e === 2) {
			        // Version mismatch.
			        console.log("Error en version de base de datos");
			    } else {
			        console.log("Error "+ e);
			    }
			    return;
			} 
		}

	
		/***
		**** CREATE TABLE ** 
		***/
	function createTables() {
			var that = this;
			UbikAppDB.transaction(
		        function (transaction) {
		        	transaction.executeSql('CREATE TABLE IF NOT EXISTS usuario(nombres text, apellidos text, mail text, fecha date, comuna int, uuid text, nick text);', [], that.nullDataHandler, that.errorHandler);
		        	transaction.executeSql('CREATE TABLE IF NOT EXISTS categoria(id int, nombre text, descripcion text);', [], that.nullDataHandler, that.errorHandler);
		        	transaction.executeSql('CREATE TABLE IF NOT EXISTS promos(id int, nombre text, descripcion text, inicio date, fin date, estado int);', [], that.nullDataHandler, that.errorHandler);
		        	
		        }
		    );
		}

		/***
		**** INSERT INTO TABLE ** 
		***/		
	function insertInicial() {
			UbikAppDB.transaction(
			    function (transaction) {

                        transaction.executeSql("INSERT INTO usuario( uuid ) VALUES ( ? )", [ device.uuid ]);
			            transaction.executeSql("insert into promos (id, nombre, descripcion, estado) values (?, ?, ?, ?)", [1, "Falabella 40% dscto.", "Deportes y Outdoor", 1]);
                        transaction.executeSql("insert into promos (id, nombre, descripcion, estado) values (?, ?, ?, ?)", [2, "Cine Hoyts a Luka", "Solo por este fin de semana", 1]);
                        transaction.executeSql("insert into promos (id, nombre, descripcion, estado) values (?, ?, ?, ?)", [3, "Ripley 50% dscto.", "Deportes y Outdoor", 1]);
                        transaction.executeSql("insert into promos (id, nombre, descripcion, estado) values (?, ?, ?, ?)", [4, "Falabella 40% dscto.", "Toda la tecnologia a tu alcance", 1]);
                        transaction.executeSql("insert into promos (id, nombre, descripcion, estado) values (?, ?, ?, ?)", [5, "Falabella 50% dscto.", "Cds y vinilos Clasicos", 1]);
                        transaction.executeSql("insert into promos (id, nombre, descripcion, estado) values (?, ?, ?, ?)", [6, "Ipciisa 50% dscto.", "En tu matricula 2015", 1]);
			        
                        transaction.executeSql("insert into categoria (id, nombre, descripcion) values (?, ?, ?)", [1, "Deportes y Outdoor", ""]);
                        transaction.executeSql("insert into categoria (id, nombre, descripcion) values (?, ?, ?)", [2, "Tecnologia", ""]);
                        transaction.executeSql("insert into categoria (id, nombre, descripcion) values (?, ?, ?)", [3, "Estudios", ""]);
                        transaction.executeSql("insert into categoria (id, nombre, descripcion) values (?, ?, ?)", [4, "Musica", ""]);
                        transaction.executeSql("insert into categoria (id, nombre, descripcion) values (?, ?, ?)", [5, "Cines", ""]);
			    
			    }
			);				
		}

	function insertCategoria() {
		UbikAppDB.transaction(
		    function (transaction) {
		        transaction.executeSql("INSERT INTO categoria() VALUES ()", []);
		    }
		);
	}

    function addCategoria(id, nombre) {
        UbikAppDB.transaction(
            function (transaction) {
                transaction.executeSql("INSERT INTO categoria(id, nombre) VALUES (?, ?)", [id, nombre]);
                location.href = "categorias.html";
            }
        );              
    }   

    function delCategoria(id) {
        UbikAppDB.transaction(
            function (transaction) {
                transaction.executeSql("DELETE FROM categoria where id = ?", [id]);
                location.href = "categorias.html";
            }
        );              
    }   

	function insertPromos() {
		UbikAppDB.transaction(
		    function (transaction) {				
			transaction.executeSql("INSERT INTO promos() VALUES ()", []);
		    }
		);				
	}

		/***
		**** UPDATE TABLE ** 
		***/
	function updateUsuario() {
			UbikAppDB.transaction(
			    function (transaction) {
	
			    	transaction.executeSql("UPDATE usuario SET nombres=?, apellidos=?, mail=?, fecha=?, comuna = ?, nick = ? WHERE uuid = ?", [$("#nombres").val(), $("#apellidos").val(), $("#correo").val(), $("#fecha").val(), $("#comuna").val(), $("#nick").val(), device.uuid]);
			    	location.href = "configuracion.html";
			    }
			);	
			
			//this.selectAll();		    
	    }

	function updatePromos(id, estado) {
			UbikAppDB.transaction(
			    function (transaction) {
										
			    	transaction.executeSql("UPDATE promos SET estado=? WHERE id = ?", [estado, id]);
			    }
			);	
			location.href = "index.html";
			//this.selectAll();		    
	    }


	function selectAllUsuario() {
	    	var that = this;
			UbikAppDB.transaction(
	    		function (transaction) {
					transaction.executeSql("SELECT * FROM usuario;", [], that.dataSelectHandler, that.errorHandler);
	        
				}
			);	
	    }
	    
	function dataSelectHandler( transaction, results ) {
			// Handle the results
			var i=0,
				row;

		    for (i ; i<results.rows.length; i++) {

		    	row = results.rows.item(i);

		    	try{
	                $("#dispositivo").html(row['nick']);

	                $("#nombres").val(row['nombres']);
	                $("#apellidos").val(row['apellidos']);
	                $("#correo").val(row['mail']);
	                $("#fecha").val(row['fecha']);
	                $("#comuna").val(row['comuna']);
                    $("#nick").val(row['nick']);
		    	    
		    	}catch (e){
		    	    console.log("err ... controlado !");
		    	}

		    }		    
	    }

    function NotificacionHandler( transaction, results ) {
        var i=0,
            row,
            res="";
        
        $("#det_notificaciones").html(""); 
        for (i ; i<results.rows.length; i++) {
            
            row = results.rows.item(i);
            
            try{
               
                if ( (i % 2) == 0){
                    
                    res += '<div class="alert alert-success">';
                    res += '<h2>' + row['nombre'] + ' <small>' + row['descripcion'] + '</small> </h2>';
                    res += '<button type="button" class="btn btn-lg btn-primary" id="acepta" value="2" onclick="updatePromos('+row['id']+', 2);">Aceptar</button>&nbsp;';
                    res += '<button type="button" class="btn btn-lg btn-danger" id="elim" value="3" onclick="updatePromos('+row['id']+', 3);">Eliminar</button>';
                    res += '</div>';
                    
                }else{
                    
                    res += '<div class="alert alert-info" align="right">';
                    res += '<h2>' + row['nombre'] + ' <small>' + row['descripcion'] + '</small> </h2>';
                    res += '<button type="button" class="btn btn-lg btn-primary" value="2" onclick="updatePromos('+row['id']+', 2);">Aceptar</button>&nbsp;';
                    res += '<button type="button" class="btn btn-lg btn-danger" value="3" onclick="updatePromos('+row['id']+', 3);">Eliminar</button>';
                    res += '</div>';
                
                }
                    
            }catch (e){
                console.log("err ... controlado !");
            }

        }
        $("#notif").html(i);
        $("#det_notificaciones").html(res);
    }
 	
    function UsadasHandler( transaction, results ) {
        var i=0,
            row,
            res="";
        
        $("#det_usadas").html(""); 
        for (i ; i<results.rows.length; i++) {
            
            row = results.rows.item(i);
            
            try{

                if ( (i % 2) == 0){

                    res += '<div class="alert alert-success">';
                    res += '<h2>' + row['nombre'] + ' <small>' + row['descripcion'] + '</small> </h2>';
                    res += '<h1>Codigo:123456</h1>';
                    res += '</div>';

                }else{

                    res += '<div class="alert alert-info" align="right">';
                    res += '<h2>' + row['nombre'] + ' <small>' + row['descripcion'] + '</small> </h2>';
                    res += '<h1>Codigo:123456</h1>';
                    res += '</div>';

                }

            }catch (e){
                console.log("err ... controlado !");
            }

        }
        $("#usadas").html(i);
        $("#det_usadas").html(res);
        
    }

    function CategoriasHandler( transaction, results ) {
        var i=0,
            row,
            res="";

        $("#det_categorias").html("");
        for (i ; i<results.rows.length; i++) {

            row = results.rows.item(i);

            try{
                if ((i % 2) == 0 ){
                    res += '&nbsp;<div class="list-group-item"><button type="button" class="btn btn-lg btn-danger" onclick="delCategoria(' + row['id'] + ')"> - </button>&nbsp;'+ row['nombre'] +'</div>';
                }else{
                    //res += '<div class="list-group-item active"><div class="checkbox"><label><input type="checkbox" value="'+ row['nombre'] +'">'+ row['nombre'] +'</label></div></div>';
                    res += '&nbsp;<div class="list-group-item active"><button type="button" class="btn btn-lg btn-danger" onclick="delCategoria(' + row['id'] + ')"> - </button>&nbsp;'+ row['nombre'] +'</div>';
                    
                }

            }catch (e){
                console.log("err ... controlado !");
            }

        }
        $("#categorias").html(i);
        $("#det_categorias").html(res);
        
    }
    
    
		/***
		**** Save 'default' data into DB table **
		***/
	function saveAll() {
		    this.insertUsuario(1);
	    }
	    
	function errorHandler( transaction, error ) {
	    
		 	if (error.code===1){
		 		// DB Table already exists
		 	} else {
		    	// Error is a human-readable string.
			    console.log('Error '+error.message+' (Codigo '+ error.code +')');
		 	}
		    return false;		    
	    }
	    
	function nullDataHandler() {
		    console.log("SQL Query OK");
	    }
	    
		/***
		**** SELECT DATA **
		***/	    
	function selectAll() {
	    	var that = this;
			UbikAppDB.transaction(
			    function (transaction) {
			        transaction.executeSql("SELECT * FROM usuario;", [], that.dataSelectHandler, that.errorHandler);
			    }
			);			    
	    }

    function selectNotificacion() {
        var that = this;
        UbikAppDB.transaction(
            function (transaction) {
                transaction.executeSql("SELECT * FROM promos where estado = 1;", [], that.NotificacionHandler, that.errorHandler);
            }
        );              
    }

    function selectUsadas() {
        var that = this;
        UbikAppDB.transaction(
            function (transaction) {
                transaction.executeSql("SELECT * FROM promos where estado = 2;", [], that.UsadasHandler, that.errorHandler);
            }
        );              
    }

    function selectCategorias() {
        var that = this;
        UbikAppDB.transaction(
            function (transaction) {
                transaction.executeSql("SELECT * FROM categoria;", [], that.CategoriasHandler, that.errorHandler);
            }
        );              
    }
    
		/***
		**** DELETE DB TABLE ** 
		***/
	function dropTables() {
			var that = this;
			UbikAppDB.transaction(
			    function (transaction) {
			    	transaction.executeSql("DROP TABLE usuario;", [], that.nullDataHandler, that.errorHandler);
			    	transaction.executeSql("DROP TABLE categoria;", [], that.nullDataHandler, that.errorHandler);
			    	transaction.executeSql("DROP TABLE promos;", [], that.nullDataHandler, that.errorHandler);
			    }
			);
			console.log("Tabls borradas");
			//location.reload();			
		}
	    

	//};

 	//Instantiate UbikApp
 	//localDBUbikApp.init();
	
//});	