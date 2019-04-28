Authentication Method Bearer, Admin User Token: RNiyjIgSw7DPHv9a4wBkM45iWOfVeoul 
i used bearer token authentication, the field in the database is the auth_key field

List data
http://apimonkeys.savocan.com/web/user
http://apimonkeys.savocan.com/web/customer

Access, Edit, Etc data
http://apimonkeys.savocan.com/web/user/id
http://apimonkeys.savocan.com/web/customer/id

Create new
http://apimonkeys.savocan.com/web/user/create
http://apimonkeys.savocan.com/web/customer/create


Data for create new customer:
{
	"name":"Name to use",
	"surname":"Surname for the client",
	"photo":"Picture url"
}
And a "file" field encoded as multipart




	"username":"Nuevousuario",
	"auth_key":"XufXp5EbQDyWasadad",
	"email":"raul@egestconsultores.com",
	"rol":"aAdmin"