
## A QR Payment System

Dadipay is a QR payment system where vendors can receive payment from their customers by scanning a QR code.

## About The Code

- ** The controller is divided into web and mobile.

- ** All API's regarding the mobile application will be written in the mobile subdirectory in controller.

- ** Validations are done in the request folder which is divided into web and mobile (for each model, you have a store request and update request)

- ** Routes are also divided into web (api_web.php) and mobile (api_mobile.php).

- ** Due to the changes i made today, we'll have to rework the Auth form endpoints again, by adding new input fields.

- ** HTTPresponses are stored in Trait.

