var App = {

	init: function(){
	},

	//this is the function for any user login. Determined by first line
	//readers do not enter password so if there is no password entered we
	//assume it is a reader else it is an admin
	login: function(id, password){
		var loginURI = id && password ? App.API.ADMIN_LOGIN : App.API.READER_LOGIN;
		var userData = {
			id:id,
			password:password	
		};

		if (!id) {
			App.modalAlert("Please Enter an id");
			return;
		}

		App.ajax(loginURI,userData,function(data){
			//True because APIs are not writen yet so not sure what i will return on fail
			if (true) {
				Datalayer.updateDatalayer(data);
				//Other functions once user logs in can go here, like redirects and transistions
			}else{
				App.modalAlert("Sorry Please Check Your Id")
			}
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
			window.location.href = "DocView.php?docid="+$(element).attr("id");
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
				$("#DocumentsTable")
					.append('<tr class="documentRow" id="'+documents[i].copyno+'">' +
								'<th scope="row">' + documents[i].docid + '</th>' 	+
								'<td>' + documents[i].title + '</td> '				+
								'<td>' + documents[i].lname + '</td> '				+
								'<td>' + documents[i].llocation + '</td>'			+
								'<td>' + "????" + '</td>'			+
								'<td> <button>Checkout</button> <button>Reserve</button> <button>Return</button></td>'			+
							'</tr>');
			}

		}
	},

	//All API URLs will go here
	API:{
		ADMIN_LOGIN:"user/admin_login",
		READER_LOGIN:"user/reader_login",
		DOC_SEARCH: "../APIs/documentByIdPubTitle.php",
		DOCS_BY_ID: "../APIs/GetAllDocCopiesById.php"
	}
}