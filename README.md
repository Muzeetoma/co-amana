# Note: This Application is Dockerized and should be ran as a docker container!

## To Get started, RUN
```bash
# Set runnable file permissions
chmod +x setup.sh and chmod +x run.sh

# Initial setup, RUN (should be run once)
./setup.sh or sudo ./setup.sh 

# Start App, RUN
./run.sh or sudo ./run.sh (if this does not run the first time execute it again or increase the sleep time)
```
===========================================================

## HomePage
```
List of Orders is @ http://localhost:8080/
```

## Login:
```
[POST] http://localhost:8080/api/login
```

```json
Login Request:
{
"email":"test@example.com",
"password": "password"
}

Login Reponse:
{
  "token": "1|BHODzkgXBVHoxHfe7zFqk56dOhb7BMStI4UbKHty2bb8d15e",
  "email": "test@example.com",
  "name": "Test User"
}
```

## Authenticated Routes:
```
Use [token] as Bearer Token
```

## View Products:
```
[GET] http://localhost:8080/api/products/5
```

## Create an Order:
```
[POST] http://localhost:8080/api/order
```

```json
OrderDto:
{
  "product_id": 1,
  "amount": "21.30",
  "quantity": 1
}
```

## Get Orders:
[GET] http://localhost:8080/api/order
