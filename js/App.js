var App = {

	init:function(){
		$("#logoutButton").on('click',function(){
			window.location.href = "index.html";
		});

		$("#search").on('keyup',function(e){
			App.ajax(App.API.AUTO_SEARCH, {searchTerm: e.target.value}, function(search){
				console.log("Auto Search: ",search);
				App.DocumentSearch.RenderDocumentsTable(search);
				$(".removeOnSearch").remove();
			});
		});

		App.ajax(App.API.AUTO_SEARCH, {searchTerm: "citro"}, function(search){
			console.log("Auto Search: ",search);
			App.DocumentSearch.RenderDocumentsTable(search);
		});
	},

	//This is the main ajax function to be used
	ajax:function(url,data,callback){
		try{
			$.ajax({
	          url:url,
	          dataType:"JSON",
	          type: "POST",
	          data: data,
	          success: function(res){
	          	callback(res);
	          },
	          error: function(err){
				console.log("Ajax Error: ",err);
				callback(err);
	          }
	        })
		}catch(e){
			console.log(e);
		}
	},

	//This function will trigger a modal to pop up with an alert
	modalAlert:function(message){
		//TBD
	},

	LoginPage: {
		init:function(){
			console.log("LoginPage init");
			$("#readerLoginButton").on('click', App.LoginPage.readerLogin);
			$("#adminLoginButton").on('click', App.LoginPage.adminLogin);
		},

		readerLogin: function(event){
			event.preventDefault();
			console.log("Loggin In reader...");
			var form = this.closest("form");
			var data = $(form).serialize();

			App.ajax(App.API.READER_LOGIN, data, function(readerData){
				console.log("READER_LOGIN: ",readerData);
				if(readerData){
					window.localStorage.setItem("userid",readerData.readerid);
					window.localStorage.setItem("username",readerData.readername);
					window.location.href = "reader.html"
				}else{
					alert("Please Check Your Login Info");
				}
			});
		},

		adminLogin: function(event){
			event.preventDefault();
			var form = this.closest("form");
			var data = $(form).serialize();

			App.ajax(App.API.ADMIN_LOGIN, data, function(adminData){
				console.log("ADMIN_LOGIN: ",adminData);
				if(adminData){
					window.localStorage.setItem("userid",adminData.readerid);
					window.localStorage.setItem("username",adminData.readername);
					window.location.href = "admin.html";
				}else{
					alert("Please Check Your Login Info");
				}
			});
		}
	},

	//All Function Related to Document Search
	DocumentSearch:{
		init: function(){
			$("#docuemntSearchFormSubmit").on("click",this.SearchForDoc);
			App.ajax(App.API.DOC_SEARCH, window.localStorage.getItem("DocumentSearchQuery") || {}, function(documents){
				App.DocumentSearch.RenderDocumentsTable(documents);
			})
		},

		SearchForDoc: function(event){
			event.preventDefault();
			var form = this.closest("form");
			var data = $(form).serialize();
			window.localStorage.setItem("DocumentSearchQuery",data);

			App.ajax(App.API.DOC_SEARCH, data, function(documents){
				console.log("SearchForDoc: ",documents);
				App.DocumentSearch.RenderDocumentsTable(documents);
			})
		},

		ViewDocument: function(event){
			var element = $(event.target).parent();
			window.location.href = "./DocView.html?docid="+$(element).attr("id");
		},

		RenderDocumentsTable: function(documents){
			$("#DocumentsTable").html("");
			for (var i = 0; i < documents.length; i++) {
				$("#DocumentsTable").append('<tr style="text-align:center" class="documentRow" id="'+documents[i].docid+'"> <th style="border: 1px solid black;">' + documents[i].docid + '</th> <td style="border: 1px solid black;">' + documents[i].title + '</td> <td style="border: 1px solid black;">' + documents[i].pubname + '</td> </tr>');
			}
			$(".documentRow").on("click",App.DocumentSearch.ViewDocument);
		}
	},

	DocumentViewByBranch: {
		init: function(){
			App.ajax(App.API.DOCS_BY_ID, {docid:window.location.href.split("docid=")[1]}, function(documents){
				App.DocumentViewByBranch.RenderDocumentsTable(documents);
			})
		},

		RenderDocumentsTable: function(documents){
			console.log(documents);
			$("#DocumentsTable").html("");
			for (var i = 0; i < documents.length; i++) {
				var status = "Available";
				var checkoutButton = "<button onClick='App.DocumentViewByBranch.Checkout("+documents[i].docid+","+documents[i].copyno+","+documents[i].libid+")' style='width: auto; position: relative;'>Checkout</button> | ";
				var reserveButton = "<button  onClick='App.DocumentViewByBranch.Reserve("+documents[i].docid+","+documents[i].copyno+","+documents[i].libid+")' style='width: auto; position: relative;'>Reserve</button> ";
				var returnButton =  "<button onClick='App.DocumentViewByBranch.Return("+documents[i].bornumber+")' style='width: auto; position: relative;'>Return</button>";

				console.log(documents[i].status)
				if (documents[i].status && documents[i].status === "0000-00-00 00:00:00") {
					status = "Not Available";
					if (documents[i].readerIdofBorrower === window.localStorage.getItem("userid")) {
						var action =  returnButton;
					}else{
						var action =  "N/A";
					}
					
				}else{
					var action = checkoutButton + reserveButton;
				}

				if (documents[i].readeridReservation) {
					var status = "Reserved";
					if (documents[i].readeridReservation === window.localStorage.getItem("userid")) {
						var action =  checkoutButton;
					}else{
						var action =  "N/A";
					}
				}

				$("#DocumentsTable")
					.append('<tr style="text-align:center" class="documentRow" id="'+documents[i].copyno+'">' +
								'<th style="border: 1px solid black;">' + documents[i].docid + '</th>' 	+
								'<td style="border: 1px solid black;">' + documents[i].title + '</td> '				+			
								'<td style="border: 1px solid black;">' + documents[i].pubname + '</td> '				+
								'<td style="border: 1px solid black;">' + documents[i].lname + '</td> '				+
								'<td style="border: 1px solid black;">' + documents[i].llocation + '</td>'			+
								'<td style="border: 1px solid black;" class="statusCell">' + status + '</td>'			+
								'<td style="border: 1px solid black;" class="actionCell">'+action+'</td>' +
							'</tr>');
			}

		},

		Checkout: function(docId, copyNo,libid){
			var data = {
				docId:docId,
				copyNo:copyNo,
				libid:libid,
				readerId: window.localStorage.getItem("userid")
			};

			App.ajax(App.API.CHECKOUT, data, function(adminData){
				console.log("ADMIN_LOGIN: ",adminData);
				window.location.reload();
			});
		},

		Return: function(bornumber){
			var data = {
				bornumber:bornumber
			};

			App.ajax(App.API.RETURN, data, function(adminData){
				console.log(": ",adminData);
				window.location.reload();
			});
		},

		Reserve: function(docId, copyNo,libid){
			var data = {
				docId:docId,
				copyNo:copyNo,
				libid:libid,
				readerId: window.localStorage.getItem("userid")
			};

			App.ajax(App.API.RESERVE, data, function(adminData){
				console.log(": ",adminData);
				window.location.reload();
			});
		}
	},

	ReservationsPage:{
		init: function(){
			App.ajax(App.API.GET_RESERVATIONS, {readerId: window.localStorage.getItem("userid")}, function(res){
				console.log("GET_RESERVATIONS: ",res);
				App.DocumentViewByBranch.RenderDocumentsTable(res);
				$(".actionCell").remove();
				$(".statusCell").remove();
			});
		}
	},

	AdminPage: {

		init:function(){
			$("#documentAddButton").on('click',function(event){
				event.preventDefault();
				console.log("Adding Book...");
				var form = this.closest("form");
				var data = $(form).serialize();

				App.ajax(App.API.ADD_DOC, data, function(data){
					console.log("READER_LOGIN: ",data);
					alert("DONE!");
				});
			})
		}

	},

	//All API URLs will go here
	API:{
		ADMIN_LOGIN:"./APIs/adminLogin.php",
		READER_LOGIN:"./APIs/readerLogin.php",
		DOC_SEARCH: "../APIs/documentByIdPubTitle.php",
		DOCS_BY_ID: "./APIs/GetAllDocCopiesById.php",
		AUTO_SEARCH:"./APIs/AutoSearch.php",
		CHECKOUT: "./APIs/Checkout.php",
		RETURN: "./APIs/Return.php",
		RESERVE: "./APIs/Reserve.php",
		GET_RESERVATIONS: './APIs/GetReservationsById.php',
		ADD_DOC:'./APIs/AddDoc.php'
	}
}