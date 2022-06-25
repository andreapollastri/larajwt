<p style="text-align:center">
 <img src="https://banners.beyondco.de/Larajwt.png?theme=light&packageManager=composer+require&packageName=andreapollastri%2Flarajwt&pattern=plus&style=style_2&description=Make+Laravel+JWT+Authentication+easy&md=1&showWatermark=0&fontSize=125px&images=identification&widths=250&heights=250" alt="Larajwt">
</p>

# Larajwt
### Make Laravel JWT Authentication easy
[![Tests](https://github.com/andreapollastri/larajwt/actions/workflows/run-tests.yml/badge.svg)](https://github.com/andreapollastri/larajwt/actions/workflows/run-tests.yml) [![PSR-12 Standard](https://github.com/andreapollastri/larajwt/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/andreapollastri/larajwt/actions/workflows/php-cs-fixer.yml)
<br><br>
## Introduction
Laravel comes with different packages suitable to manage Stateless and Stateful Authentication inside projects, but JWT is missing. This package lets you to easily add and manage JWT into your Laravel applications.
<br><br>

## Getting Started

- Install Vendor:

```shell
composer require andreapollastri/larajwt
```

- Export the package migration:

```shell
php artisan vendor:publish --provider="Andr3a\Larajwt\LarajwtServiceProvider" --tag="larajwt-migrations"
```

- Run migrations:

```shell
php artisan migrate
```

- Add the middleware "jwt" to each authenticable route:

```php
->middleware(['jwt'])
```

- Set two secrets into your .env file (learn more here https://jwt.io/introduction):
```
JWT_ACCESS_TOKEN_SECRET_KEY=<SET-A-SECRET>
JWT_REFRESH_TOKEN_SECRET_KEY=<SET-ANOTHER-SECRET>
```
<br><br>

## Custom Configuration

Larajwt has default configurations about JWT Secrets and Tokens Validation Time.<br>
To customize them export and edit the config/larajwt.php file:

```shell
php artisan vendor:publish --provider="Andr3a\Larajwt\LarajwtServiceProvider" --tag="larajwt-config"
```
<br><br>

## API Documentation
<br>

#### Login Endpoint
Get JWT Tokens to login the User.

```http
POST /api/auth
```

Request Header
| Parameter | Type | Description |
| :--- | :--- | :--- |
| `Content-Type` | `string` | **Required**. application/json |
| `Accept` | `string` | **Required**. application/json |

Request Body Payload
| Parameter | Type | Description |
| :--- | :--- | :--- |
| `username` | `string` | **Required**. User username |
| `password` | `string` | **Required**. User password |

Response
| Parameter | Type | Description |
| :--- | :--- | :--- |
| `access_token` | `string` | The JWT Access Token for the User. |
| `refresh_token` | `string` | The JWT Refresh Token for the User. |
| `expires_in` | `integer` | The number of seconds the access token is valid. |
| `token_type` | `string` | Will always be bearer. |

<br>

#### "ME" Endpoint
Get Authentication Status and User Data Information.

```http
GET /api/auth
```

Request Header
| Parameter | Type | Description |
| :--- | :--- | :--- |
| `Authorization` | `string` | **Required**. Bearer Access Token |
| `Content-Type` | `string` | **Required**. application/json |
| `Accept` | `string` | **Required**. application/json |

Response
| Parameter | Type | Description |
| :--- | :--- | :--- |
| `user` | `object` | User data information |

<br>

#### Refresh Endpoint
Refresh JWT Tokens.

```http
PATCH /api/auth
```

Request Header
| Parameter | Type | Description |
| :--- | :--- | :--- |
| `Content-Type` | `string` | **Required**. application/json |
| `Accept` | `string` | **Required**. application/json |

Request Body Payload
| Parameter | Type | Description |
| :--- | :--- | :--- |
| `refresh_token` | `string` | **Required**. JWT Refresh Token |

Response
| Parameter | Type | Description |
| :--- | :--- | :--- |
| `access_token` | `string` | The JWT Access Token for the User. |
| `refresh_token` | `string` | The JWT Refresh Token for the User. |
| `expires_in` | `integer` | The number of seconds the access token is valid. |
| `token_type` | `string` | Will always be bearer. |

<br>

#### Logout Endpoint
Revoke User Session to logout the User.

```http
DELETE /api/auth
```

Request Header
| Parameter | Type | Description |
| :--- | :--- | :--- |
| `Authorization` | `string` | **Required**. Bearer Access Token |
| `Content-Type` | `string` | **Required**. application/json |
| `Accept` | `string` | **Required**. application/json |

<br><br>

## API Response Status Codes
Revoke User Session to logout the User.

Request Header
| Status | Type | Description |
| :--- | :--- | :--- |
| 200 | OK | Successful Action |
| 401 | Error | Invalid or Expired Token (Unauthorized) |
| 422 | Error | Invalid or Missed Payload (Bad Request) |

<br><br>

## Security Vulnerabilities and Bugs
If you discover any security vulnerability or any bug within larajwt, please open an issue.
<br><br>

## Contributing
Thank you for considering contributing to this project!
<br><br>

## Licence
Larajwt is open-source software licensed under the MIT license.
<br><br> 

### Enjoy larajwt ;)
