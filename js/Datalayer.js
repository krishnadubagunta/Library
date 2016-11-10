/*
	This is the datalayer. all data returned from APIs will be stored here 
	so that we can access for other us across the app.
*/
var Datalayer = {
	data: {},

	updateDatalayer: function(newData){
		return Object.assign(this.data,newData);
	},

	setUser: function(user){
		if (!user.id || !user.email) {
			throw "setUser: user id and email not set";
		}

		return Object.assign(this.data,{
			user:{
				id:user.id,
				email:user.email
			}
		});
	},

	getUser: function(){
		return this.data.user;
	},

	removeUser: function(){
		delete this.data.user;
		return this.data;
	}
};