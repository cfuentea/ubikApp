//<script src="db_ubikapp.js" type="text/javascript" charset="utf-8"></script>
$(function(){ 
	
	var localDBUbikApp = {
		init: function () {
			
			//this.initDatabase();
			
			// Button and link actions
			/*$('#clear').on('click', function(){ 
				localDBUbikApp.dropTables(); 
			});
			
		 	$('#update').on('click', function(){ 
		 		localDBUbikApp.updateSetting(); 
		 	});*/

		},

		initDatabase: function() {
			try {
			    if (!window.openDatabase) {
			        alert('UbikApp no soportado por dispositivo');
			    } else {
			        var shortName = 'UbikAppDB',
			        	version = '1.0',
						displayName = 'UbikAppDB',
						maxSize = 1024*1024;
						
			        UbikAppDB = openDatabase(shortName, version, displayName, maxSize);
					this.createTables();
					//this.selectAll();
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
		},
		
		/***
		**** CREATE TABLE ** 
		***/
		createTables: function() {
			var that = this;
			UbikAppDB.transaction(
		        function (transaction) {
		        	transaction.executeSql('CREATE TABLE IF NOT EXISTS usuario();', [], that.nullDataHandler, that.errorHandler);
		        	transaction.executeSql('CREATE TABLE IF NOT EXISTS categoria();', [], that.nullDataHandler, that.errorHandler);
		        	transaction.executeSql('CREATE TABLE IF NOT EXISTS promos();', [], that.nullDataHandler, that.errorHandler);
		        }
		    );
			//this.insertUsuario();			
		},

		/***
		**** INSERT INTO TABLE ** 
		***/		
		insertUsuario: function() {
			UbikAppDB.transaction(
			    function (transaction) {
				//var data = ['1','none','#B3B4EF','Helvetica','Porsche 911 GT3'];  
				
				//transaction.executeSql("INSERT INTO example(id, fname, bgcolor, font, favcar) VALUES (?, ?, ?, ?, ?)", [data[0], data[1], data[2], data[3], data[4]]);
			    transaction.executeSql("INSERT INTO usuario() VALUES ()", []);
			    }
			);				
		},

		insertCategoria: function() {
			UbikAppDB.transaction(
			    function (transaction) {
				
				transaction.executeSql("INSERT INTO categoria() VALUES ()", []);
			    }
			);				
		},		

		insertPromos: function() {
			UbikAppDB.transaction(
			    function (transaction) {
				
				transaction.executeSql("INSERT INTO promos() VALUES ()", []);
			    }
			);				
		},

		/***
		**** UPDATE TABLE ** 
		***/
	    updateUsuario: function() {
			UbikAppDB.transaction(
			    function (transaction) {
					/*var fname,
					bg    = $('#bg_color').val(),
					font  = $('#font_selection').val(),
					car   = $('#fav_car').val();
					
			    	if($('#fname').val() != '') {
			    		fname = $('#fname').val();
			    	} else {
			    		fname = 'none';
			    	}*/
					
			    	transaction.executeSql("UPDATE usuario SET fname=?, bgcolor=?, font=?, favcar=? WHERE id = 1", [fname, bg, font, car]);
			    }
			);	
			
			//this.selectAll();		    
	    },

	    updatePromos: function() {
			UbikAppDB.transaction(
			    function (transaction) {
										
			    	transaction.executeSql("UPDATE promos SET estado=? WHERE id = ?", ["usada", "1"]);
			    }
			);	
			
			//this.selectAll();		    
	    },
	    
	    selectAllUsuario: function() {
	    	var that = this;
			UbikAppDB.transaction(
	    		function (transaction) {
					transaction.executeSql("SELECT * FROM usuario;", [], that.dataSelectHandler, that.errorHandler);
	        
				}
			);	
	    },
	    
	    dataSelectHandler: function( transaction, results ) {
			// Handle the results
			var i=0,
				row;
				
		    for (i ; i<results.rows.length; i++) {
		        
		    	row = results.rows.item(i);
		        
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
		
		    }		    
	    },
	    
		/***
		**** Save 'default' data into DB table **
		***/
	    saveAll: function() {
		    this.insertUsuario(1);
	    },
	    
	    errorHandler: function( transaction, error ) {
	    
		 	if (error.code===1){
		 		// DB Table already exists
		 	} else {
		    	// Error is a human-readable string.
			    console.log('Error '+error.message+' (Codigo '+ error.code +')');
		 	}
		    return false;		    
	    },
	    
	    nullDataHandler: function() {
		    console.log("SQL Query OK");
	    },
	    
		/***
		**** SELECT DATA **
		***/	    
	    selectAll: function() {
	    	var that = this;
			UbikAppDB.transaction(
			    function (transaction) {
			        transaction.executeSql("SELECT * FROM usuario;", [], that.dataSelectHandler, that.errorHandler);
			    }
			);			    
	    },
	    
		/***
		**** DELETE DB TABLE ** 
		***/
		dropTables: function() {
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
	    

	};

 	//Instantiate UbikApp
 	//localDBUbikApp.init();
	
});	