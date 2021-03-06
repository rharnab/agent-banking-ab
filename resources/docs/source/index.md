---
title: E-KYC API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://venturesolutionsltd.com/'>Documentation Powered by Venture Solution Limited</a>
---
<!-- START_INFO -->
# Info

Welcome to the E-KYC API reference.

<!-- END_INFO -->

#API Authentication


<!-- START_02a39415df20bccffb0cce75c80c89dd -->
## api/auth-info
<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/auth-info" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://localhost/api/auth-info"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "status": 200,
    "success": true,
    "message": "success",
    "data": {
        "name": "Venture Solution Limited",
        "email": "vsl@gmail.com",
        "api_token": "$2a$09$w8G5k9SiK0WQctXclwu6TuN7RclNeRNaz2DZ4s9bGiP0cALrFRhAG$2a$09$w8G5k9SiK0WQc"
    }
}
```
> Example response (401):

```json
{
    "status": 401,
    "success": false,
    "message": "unathencticated user"
}
```

### HTTP Request
`GET api/auth-info`


<!-- END_02a39415df20bccffb0cce75c80c89dd -->

#general


<!-- START_27fb411207c7fe31fc3477f33a72c763 -->
## Customer Registration

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/api/registartion" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"phone":"01712345678","email":"example@ekyc.com"}'

```

```javascript
const url = new URL(
    "http://localhost/api/registartion"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "phone": "01712345678",
    "email": "example@ekyc.com"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "status": 200,
    "success": true,
    "message": "registation success",
    "data": {
        "customer_id": 107
    }
}
```
> Example response (400):

```json
{
    "status": 400,
    "success": false,
    "message": "please give your mobile_number"
}
```

### HTTP Request
`POST api/registartion`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `phone` | numeric |  required  | phone number must be numberic,unique
        `email` | string |  optional  | optional  phone number must be numberic,unique
    
<!-- END_27fb411207c7fe31fc3477f33a72c763 -->

<!-- START_77ad6cd0e5dba8ea02dc64af48cee529 -->
## Customer Nid-Ocr

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/api/nid-ocr" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"customer_id":1,"nid_front_image":"data:image\/png;base64,iVBORw0KGgoAAAANSUhEUgAAAf4AAAE7CAMAAAAL","nid_back_image":"data:image\/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgMAAAFACAMAAAAWIY8"}'

```

```javascript
const url = new URL(
    "http://localhost/api/nid-ocr"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "customer_id": 1,
    "nid_front_image": "data:image\/png;base64,iVBORw0KGgoAAAANSUhEUgAAAf4AAAE7CAMAAAAL",
    "nid_back_image": "data:image\/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgMAAAFACAMAAAAWIY8"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "status": 200,
    "success": true,
    "message": "nid-ocr successfully",
    "data": {
        "customer_id": "108",
        "english_name": "MD. SAMIUL HAQUE",
        "nid_number": "6410581760",
        "date_of_birth": "1995-11-19"
    }
}
```
> Example response (400):

```json
{
    "status": 400,
    "success": false,
    "message": "please give nid front image"
}
```

### HTTP Request
`POST api/nid-ocr`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `customer_id` | integer |  required  | customer_id for slef varification into the E-KYC
        `nid_front_image` | text |  required  | nid_front_image base64 format send for OCR Nid Front Part
        `nid_back_image` | text |  required  | nid_back_image base64 format send for OCR Nid Back Part
    
<!-- END_77ad6cd0e5dba8ea02dc64af48cee529 -->

<!-- START_6a288f973c16aa2187a740c80e8a5e91 -->
## OCR Ammendment

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/api/ammendment-ocr-data" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"customer_id":1,"english_name":"Md.Rabiul Hasan","nid_back_image":"123 456 7890","date_of_birth":"1997-04-13"}'

```

```javascript
const url = new URL(
    "http://localhost/api/ammendment-ocr-data"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "customer_id": 1,
    "english_name": "Md.Rabiul Hasan",
    "nid_back_image": "123 456 7890",
    "date_of_birth": "1997-04-13"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "status": 200,
    "success": true,
    "message": "ocr-ammendment successfully",
    "data": {
        "customer_id": "108"
    }
}
```
> Example response (400):

```json
{
    "status": 400,
    "success": false,
    "message": "nid number already exists"
}
```
> Example response (400):

```json
{
    "status": 400,
    "success": false,
    "message": "please give english name"
}
```

### HTTP Request
`POST api/ammendment-ocr-data`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `customer_id` | integer |  required  | customer_id for slef varification into the E-KYC
        `english_name` | text |  required  | English Name Ammendment If OCR Read Wrong Data
        `nid_back_image` | text |  required  | NID Number Ammendment If OCR Read Wrong Data
        `date_of_birth` | text |  required  | Date Of Birth ammendment If OCR Read Wrong Data
    
<!-- END_6a288f973c16aa2187a740c80e8a5e91 -->

<!-- START_cc3d3a48f2f1e1ea5a940993450e813f -->
## Customer Face Verification

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/api/face-verification" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"customer_id":1,"face_image":"data:image\/png;base64,iVBORw0KGgoAAAANSUhEUgAAAf4AAAE7CAMAAAAL"}'

```

```javascript
const url = new URL(
    "http://localhost/api/face-verification"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "customer_id": 1,
    "face_image": "data:image\/png;base64,iVBORw0KGgoAAAANSUhEUgAAAf4AAAE7CAMAAAAL"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "status": 200,
    "success": true,
    "message": "face varification success",
    "data": {
        "customer_id": "108",
        "isIdentical": true,
        "recognize_percentage": 66.713,
        "required_percentage": 50,
        "verified": true
    }
}
```
> Example response (400):

```json
{
    "status": 400,
    "success": false,
    "message": "face identification failed",
    "data": {
        "isIdentical": false,
        "recognize_percentage": "14.34",
        "verified": false
    }
}
```
> Example response (400):

```json
{
    "status": 400,
    "success": false,
    "message": "does no fillup required percentage",
    "data": {
        "isIdentical": true,
        "recognize_percentage": 66.713,
        "required_percentage": 80,
        "verified": false
    }
}
```

### HTTP Request
`POST api/face-verification`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `customer_id` | integer |  required  | customer_id for slef varification into the E-KYC
        `face_image` | text |  required  | face_image base64 format send for Face Verification
    
<!-- END_cc3d3a48f2f1e1ea5a940993450e813f -->

<!-- START_74255e7aff58bcdff49b89dbfb9163a3 -->
## Customer Signature Upload

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/api/signature-upload" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"customer_id":1,"signature_image":"data:image\/png;base64,iVBORw0KGgoAAAANSUhEUgAAAf4AAAE7CAMAAAAL"}'

```

```javascript
const url = new URL(
    "http://localhost/api/signature-upload"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "customer_id": 1,
    "signature_image": "data:image\/png;base64,iVBORw0KGgoAAAANSUhEUgAAAf4AAAE7CAMAAAAL"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "status": 200,
    "success": true,
    "message": "signature upload successfully",
    "data": {
        "customer_id": "106",
        "bangla_name": "???????????? ?????????????????? ??????",
        "blood_group": "",
        "date_of_birth": "1990-01-15",
        "father_name": "???????????? ?????????????????? ??????",
        "mother_name": "????????????",
        "address": "?????????????????????????????????????????? ???????????????????????? ??????????????? ???????????? ?????????????????? ?????? ???????????? ???????????? ?????????????????? ?????? ???????????? ?????????????????? ??????"
    }
}
```
> Example response (404):

```json
{
    "status": 404,
    "success": false,
    "message": "customer not found"
}
```

### HTTP Request
`POST api/signature-upload`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `customer_id` | integer |  required  | customer_id for slef varification into the E-KYC
        `signature_image` | text |  required  | signature_image base64 format send for Signature
    
<!-- END_74255e7aff58bcdff49b89dbfb9163a3 -->

<!-- START_48f7fa60a24de307bdcff61eb53c7ccb -->
## All Branch List

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/api/branch-list" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://localhost/api/branch-list"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "status": 200,
    "success": true,
    "message": "success",
    "data": {
        "all_branch_lis": [
            {
                "id": 1,
                "name": "BARISAL"
            },
            {
                "id": 2,
                "name": "BOGRA"
            }
        ]
    }
}
```

### HTTP Request
`POST api/branch-list`


<!-- END_48f7fa60a24de307bdcff61eb53c7ccb -->

<!-- START_bab725a70a031cad69b4709fad4ef449 -->
## All Account Types

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/api/account-types" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}"
```

```javascript
const url = new URL(
    "http://localhost/api/account-types"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "status": 200,
    "success": true,
    "message": "success",
    "data": {
        "all_account_types": [
            {
                "id": 1,
                "name": "Cash Security For BTB"
            },
            {
                "id": 2,
                "name": "Saving Deposite(General)"
            }
        ]
    }
}
```

### HTTP Request
`POST api/account-types`


<!-- END_bab725a70a031cad69b4709fad4ef449 -->

<!-- START_948d0fe0a7f55821e92eb609a5104370 -->
## Customer Review Information

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/api/review-information" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"customer_id":18,"english_name":"1","bangla_name":"1","blood_group":"1","date_of_birth":"1","father_name":"1","mother_name":"1","address":"1"}'

```

```javascript
const url = new URL(
    "http://localhost/api/review-information"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "customer_id": 18,
    "english_name": "1",
    "bangla_name": "1",
    "blood_group": "1",
    "date_of_birth": "1",
    "father_name": "1",
    "mother_name": "1",
    "address": "1"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "status": 200,
    "success": true,
    "message": "review-data successfully",
    "data": {
        "customer_id": "108"
    }
}
```
> Example response (400):

```json
{
    "status": 400,
    "success": false,
    "message": "The date of birth field is required."
}
```

### HTTP Request
`POST api/review-information`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `customer_id` | integer |  required  | customer_id for slef varification into the E-KYC Example                   : 1
        `english_name` | string |  required  | english_name review for data matching more accurecy
        `bangla_name` | string |  required  | bangla_name review for data matching more accurecy
        `blood_group` | string |  required  | blood_group review for data matching more accurecy
        `date_of_birth` | date |  required  | date_of_birth review for data matching more accurecy
        `father_name` | string |  required  | father_name review for data matching more accurecy
        `mother_name` | string |  required  | mother_name review for data matching more accurecy
        `address` | text |  required  | address review for data matching more accurecy
    
<!-- END_948d0fe0a7f55821e92eb609a5104370 -->

<!-- START_23a4a4e7c793603912cc1266c0c961c4 -->
## Account Opening Requst Form

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```bash
curl -X POST \
    "http://localhost/api/account-opening" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -H "Authorization: Bearer {token}" \
    -d '{"customer_id":6,"branch_code":1,"account_type":1,"monthly_income":"nobis","monthly_deposit":"sed","monthly_withdraw":"porro","nominee_name":"sapiente","nominee_nid_number":"harum","nominee_address":"reiciendis"}'

```

```javascript
const url = new URL(
    "http://localhost/api/account-opening"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "Authorization": "Bearer {token}",
};

let body = {
    "customer_id": 6,
    "branch_code": 1,
    "account_type": 1,
    "monthly_income": "nobis",
    "monthly_deposit": "sed",
    "monthly_withdraw": "porro",
    "nominee_name": "sapiente",
    "nominee_nid_number": "harum",
    "nominee_address": "reiciendis"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "status": 200,
    "success": true,
    "message": "account opening request successfully"
}
```
> Example response (400):

```json
{
    "status": 400,
    "success": false,
    "message": "please give branch code"
}
```
> Example response (400):

```json
{
    "status": 400,
    "success": false,
    "message": "already account opening request",
    "data": {
        "message": "your account opening request has been pending.Bank authority will contact as soon as possible"
    }
}
```

### HTTP Request
`POST api/account-opening`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `customer_id` | integer |  required  | customer_id for slef varification into the E-KYC Example                   : 1
        `branch_code` | integer |  required  | branch_code for which branch customer send account opening request
        `account_type` | integer |  required  | account_type for which type account you want to create
        `monthly_income` | numeric |  required  | monthly_income for customer  account opening request Example           : 10000
        `monthly_deposit` | numeric |  required  | monthly_deposit for customer  account opening request Example         : 10000
        `monthly_withdraw` | numeric |  required  | monthly_withdraw for customer  account opening request Example       : 10000
        `nominee_name` | string |  required  | nominee_name for customer  account opening request Example                : Rabiul Hasan
        `nominee_nid_number` | string |  required  | nominee_nid_number for customer  account opening request Example    : 123 456 7890
        `nominee_address` | string |  required  | nominee_address for customer  account opening request Example          : Dhaka, Bangladesh
    
<!-- END_23a4a4e7c793603912cc1266c0c961c4 -->


