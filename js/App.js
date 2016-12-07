var App = {

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
			$("#readerLoginButton").on('click', App.LoginPage.readerLogin);
			$("#adminLoginButton").on('click', App.LoginPage.adminLogin);
		},

		readerLogin: function(event){
			event.preventDefault();
			var form = this.closest("form");
			var data = $(form).serialize();

			App.ajax(App.API.READER_LOGIN, data, function(readerData){
				console.log("READER_LOGIN: ",readerData);
			});
		},

		adminLogin: function(event){
			event.preventDefault();
			var form = this.closest("form");
			var data = $(form).serialize();

			App.ajax(App.API.ADMIN_LOGIN, data, function(adminData){
				console.log("ADMIN_LOGIN: ",adminData);
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
			window.location.href = "DocView.html?docid="+$(element).attr("id");
		},

		RenderDocumentsTable: function(documents){
			$("#DocumentsTable").html("");
			for (var i = 0; i < documents.length; i++) {
				$("#DocumentsTable").append('<tr class="documentRow" id="'+documents[i].docid+'"> <th scope="row">' + documents[i].docid + '</th> <td>' + documents[i].title + '</td> <td>' + documents[i].pubname + '</td> </tr>');
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
				var action = "<button>Checkout</button> <button>Reserve</button> <button>Return</button>";
				if (documents[i].status && documents[i].status ==="0000-00-00 00:00:00") {
					status = "Not Available";
					action = "<button>Return</button>";
				}

				$("#DocumentsTable")
					.append('<tr class="documentRow" id="'+documents[i].copyno+'">' +
								'<th scope="row">' + documents[i].docid + '</th>' 	+
								'<td>' + documents[i].title + '</td> '				+
								'<td>' + documents[i].lname + '</td> '				+
								'<td>' + documents[i].llocation + '</td>'			+
								'<td>' + status + '</td>'			+
								'<td>'+action+'</td>'			+
							'</tr>');
			}

		}
	},

	//All API URLs will go here
	API:{
		ADMIN_LOGIN:"../APIs/adminLogin.php",
		READER_LOGIN:"../APIs/readerLogin.php",
		DOC_SEARCH: "../APIs/documentByIdPubTitle.php",
		DOCS_BY_ID: "../APIs/GetAllDocCopiesById.php"
	}
}