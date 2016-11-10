var App = {
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
	          success: function(data){
	          	callback(data);
	          },
	          error: function(data){
				console.log(e);
				callback(data);
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

	//All API URLs will go here
	API:{
		ADMIN_LOGIN:"user/admin_login",
		READER_LOGIN:"user/reader_login"
	}
}