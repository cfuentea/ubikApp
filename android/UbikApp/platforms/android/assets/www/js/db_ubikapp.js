//<script src="db_ubikapp.js" type="text/javascript" charset="utf-8"></script>
//$(function(){ 
	
	var localDBUbikApp; //= {
	var UbikAppDB = null;
	
	function init() {
			
			this.initDatabase();

			this.selectAll();
			
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
			        //this.dropTables()
					this.createTables();
					//this.selectAll();
					this.insertUsuario();
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
		        	transaction.executeSql('CREATE TABLE IF NOT EXISTS promos(id int, nombre text, descripcion text, inicio date, fin date);', [], that.nullDataHandler, that.errorHandler);
		        }
		    );
			//this.insertUsuario();			
		}

		/***
		**** INSERT INTO TABLE ** 
		***/		
	function insertUsuario() {
			UbikAppDB.transaction(
			    function (transaction) {
				//var data = ['1','none','#B3B4EF','Helvetica','Porsche 911 GT3'];  
				
				//transaction.executeSql("INSERT INTO example(id, fname, bgcolor, font, favcar) VALUES (?, ?, ?, ?, ?)", [data[0], data[1], data[2], data[3], data[4]]);
			        
			        if (!existeUsuario()){
			            alert("no existe " + device.uuid);
                        //transaction.executeSql("INSERT INTO usuario(nombres, apellidos, mail, fecha, comuna, uuid, nick) VALUES (?, ?, ?, ?, ?, ?, ?)", ["Cristian", "Yanez", "cyanez@ubikapp.cl", new Date(), 100, device.uuid]);
			            transaction.executeSql("INSERT INTO usuario( uuid ) VALUES ( ? )", [ device.uuid ]);
			        }			        
			        
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

	function updatePromos() {
			UbikAppDB.transaction(
			    function (transaction) {
										
			    	transaction.executeSql("UPDATE promos SET estado=? WHERE id = ?", ["usada", "1"]);
			    }
			);	
			
			//this.selectAll();		    
	    }

	function existeUsuario() {
            var that = this;
            UbikAppDB.transaction(
                function (transaction) {
                    transaction.executeSql("SELECT * FROM usuario where uuid = ?;", [device.uuid], that.existHandler, that.errorHandler);
            
                }
            );  
        }
        
	function existHandler( transaction, result ) {
            // Handle the results
            var i=0,
                row;
            
            alert(result.rows.length);

            for (i ; i<result.rows.length; i++) {
                row = result.rows.item(i);
                alert(row['nombres'] + " - " + row['uuid'])
                return true;
                        
            }
            return false;
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


		    	/*
		        $('body').css('background-color',row['bgcolor']);
		        $('body').css('font-family',row['font']);
		        $('#content').html('<h4 id="your_car">Your Favorite Car is a '+ row['favcar'] +'</h4>');
		        
		        if(row['fname'] != 'none') {
		       		$('#greeting').html('Howdy-ho, '+ row['fname'] +'!');
		       		$('#fname').val( row['fname'] );
		        } 
		        
		       $('select#font_selection').find('option[value="'+ row['font'] +'"]').attr('selected','selected');
		       $('select#bg_color').find('option[value="'+ row['bgcolor'] +'"]').attr('selected','selected');  
		       $('select#fav_car').find('option[value="'+ row['favcar'] +'"]').attr('selected','selected');
		        */
		    }		    
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