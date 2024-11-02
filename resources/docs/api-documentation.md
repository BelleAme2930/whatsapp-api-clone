## User Registration API

#### Endpoint: Register a New User

- **URL**: `https://whatsapp-api-clone.umairsaif.net/api/register`
- **Endpoint**: `/register`
- **Method**: `POST`
- **Description**: Registers a new user by validating and storing their credentials, then logs them in automatically.

---

### Request

**Headers**

- `Content-Type`: `application/json`

**Body Parameters**

| Parameter               | Type     | Required | Description                          |
|-------------------------|----------|----------|--------------------------------------|
| `name`                  | string   | Yes      | Full name of the user                |
| `email`                 | string   | Yes      | Email address, must be unique        |
| `password`              | string   | Yes      | Password (must meet security rules)  |
| `password_confirmation` | string   | Yes      | Confirmation of the password         |

**Example Request**

```json
{
  "name": "John Doe",
  "email": "johndoe@example.com",
  "password": "password",
  "password_confirmation": "password"
}
```
---
### Responses
* __Status:__ 201 (Created)
* __Description:__ User registered successfully.
* __Body:__

```json
{
  "message": "User registered successfully.",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "created_at": "2024-11-02"
  }
}
```
---
* __Status:__ 409 (Conflict)
* __Description:__ The email has already been taken.
* __Body:__

```json
{
  "message": "The email has already been taken. Please choose another one."
}
```
---
## User Login API

#### Endpoint: Authenticate User

- **URL**: `https://whatsapp-api-clone.umairsaif.net/api/login`
- **Endpoint**: `/login`
- **Method**: `POST`
- **Description**: Authenticates a user by validating their credentials and provides an access token for subsequent requests.

---

### Request

**Headers**

- `Content-Type`: `application/json`

**Body Parameters**

| Parameter  | Type   | Required | Description                          |
|------------|--------|----------|--------------------------------------|
| `email`    | string | Yes      | Email address of the user            |
| `password` | string | Yes      | Password of the user                 |

**Example Request**

```json
{
  "email": "johndoe@example.com",
  "password": "password"
}
```
---
### Responses
-  __Status:__ 200 (OK)
-  __Description:__ User authenticated successfully.
-  __Body:__

```json
{
  "message": "Login successful.",
  "token": "2|KymEiAGRGP6uIbNCI7gH4dRnmMdPIamI863ccZcQc210108f",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "johndoe@example.com",
    "created_at": "2024-11-02"
  }
}
```
---
* __Status:__ 401 (Unauthorized)
* __Description:__ User not authenticated, invalid credentials.
* __Body:__

```json
{
  "message": "User not authenticated."
}
```
---
## Create Chatroom API

#### Endpoint: Create a New Chatroom

- **URL**: `https://whatsapp-api-clone.umairsaif.net/api/chatrooms`
- **Endpoint**: `/chatrooms`
- **Method**: `POST`
- **Description**: Creates a new chatroom with a specified name and maximum number of members.

---

### Request

**Headers**

- `Authorization`: `Bearer {token}`
- `Content-Type`: `application/json`

**Body Parameters**

| Parameter  | Type   | Required | Description                          |
|------------|--------|----------|--------------------------------------|
| `name`    | string | Yes      | The name of the chatroom            |
| `max_members` | integer | Yes      | The maximum number of members allowed in the chatroom                 |

**Example Request**

```json
{
  "name": "General Discussion",
  "max_members": 50
}

```
---
### Responses
-  __Status:__ 201 (Created)
-  __Description:__ Chatroom created successfully.
-  __Body:__

```json
{
  "id": 1,
  "name": "General Discussion",
  "max_members": 50,
  "created_at": "2024-11-02T12:00:00.000000Z",
  "updated_at": "2024-11-02T12:00:00.000000Z"
}
```
---
* __Status:__ 400 (Bad Request)
* __Description:__ Validation errors occur when the request parameters do not meet the specified requirements.
* __Body:__

```json
{
  "errors": {
    "name": ["The name field is required."],
    "max_members": ["The max members field is required.", "The max members must be an integer.", "The max members must be at least 1."]
  }
}
```
---
## List Chatrooms API

#### Endpoint: Retrieve All Chatrooms

- **URL**: `https://whatsapp-api-clone.umairsaif.net/api/chatrooms`
- **Endpoint**: `/chatrooms`
- **Method**: `GET`
- **Description**: Retrieves a list of all chatrooms.

---

### Request

**Headers**

- `Authorization`: `Bearer {token}`
- `Content-Type`: `application/json`

**Example Request**

```
GET /chatrooms HTTP/1.1<br>
Authorization: Bearer {token}
```
---
### Responses
-  __Status:__ 200 (OK)
-  __Description:__ Successfully retrieved the list of chatrooms.
-  __Body:__

```json
[
  {
    "id": 1,
    "name": "General Discussion",
    "max_members": 50,
    "created_at": "2024-11-02T12:00:00.000000Z",
    "updated_at": "2024-11-02T12:00:00.000000Z"
  },
  {
    "id": 2,
    "name": "Tech Talk",
    "max_members": 30,
    "created_at": "2024-11-02T12:00:00.000000Z",
    "updated_at": "2024-11-02T12:00:00.000000Z"
  }
]
```
---
* __Status:__ 401 (Unauthorized)
* __Description:__ Validation errors occur when the request parameters do not meet the specified requirements.
* __Body:__

```json
{
  "message": "User not authenticated."
}
```
---
## Enter Chatroom API

#### Endpoint: Join a Chatroom

- **URL**: `https://whatsapp-api-clone.umairsaif.net/api/chatrooms/{chatroomId}/join`
- **Endpoint**: `/chatrooms/{chatroomId}/join`
- **Method**: `POST`
- **Description**: Allows a user to join a specified chatroom if they are not already a member and if the chatroom is not full.

---

### Request

**Headers**

- `Authorization`: `Bearer {token}`
- `Content-Type`: `application/json`

**Body Parameters**

| Parameter  | Type   | Required | Description                          |
|------------|--------|----------|--------------------------------------|
| `chatroomId`    | integer | Yes      | The ID of the chatroom to join            |

**Example Request**

```
POST /chatrooms/1/join HTTP/1.1<br>
Authorization: Bearer {token}
```
---
### Responses
-  __Status:__ 200 (OK)
-  __Description:__ Successfully joined the chatroom.
-  __Body:__

```json
{
  "message": "Successfully entered the chatroom"
}
```
---
* __Status:__ 404 (Not Found)
* __Description:__ The specified chatroom does not exist.
* __Body:__

```json
{
  "message": "Chatroom not found"
}
```
---
* __Status:__ 400 (Bad Request)
* __Description:__ The user is already a member of the chatroom.
* __Body:__

```json
{
  "message": "User already in the chatroom"
}
```
---
---
* __Status:__ 400 (Bad Request)
* __Description:__ The chatroom is full and cannot accommodate more members.
* __Body:__

```json
{
  "message": "Chatroom is full"
}
```
---
## Leave a Chatroom

#### Endpoint: Leave a Chatroom

- **URL**: `https://whatsapp-api-clone.umairsaif.net/api/chatrooms/{chatroomId}/leave`
- **Endpoint**: `/chatrooms/{chatroomId}/leave`
- **Method**: `POST`
- **Description**: Allows a user to leave a specified chatroom.

---

### Request

**Headers**

- `Authorization`: `Bearer {token}`
- `Content-Type`: `application/json`

**Body Parameters**

| Parameter  | Type   | Required | Description                          |
|------------|--------|----------|--------------------------------------|
| `chatroomId`    | integer | Yes      | The ID of the chatroom to leave            |

**Example Request**

```
POST /chatrooms/1/leave HTTP/1.1
Authorization: Bearer {token}
```
---
### Responses
-  __Status:__ 200 (OK)
-  __Description:__ Successfully left the chatroom.
-  __Body:__

```json
{
  "message": "Successfully left the chatroom"
}
```
---
* __Status:__ 404 (Not Found)
* __Description:__ The specified chatroom does not exist.
* __Body:__

```json
{
  "message": "Chatroom not found"
}
```
---
## Send Message

#### Endpoint: Send a Message to a Chatroom

- **URL**: `https://whatsapp-api-clone.umairsaif.net/api/chatrooms/{chatroomId}/messages`
- **Endpoint**: `/chatrooms/{chatroomId}/messages`
- **Method**: `POST`
- **Description**: Sends a message to a specified chatroom, with an optional file attachment.

---

### Request

**Headers**

- `Authorization`: `Bearer {token}`
- `Content-Type`: `application/json` (for text messages)
- `multipart/form-data`: `application/json` (for messages with attachments)

**Path Parameters**

| Parameter  | Type   | Required | Description                          |
|------------|--------|----------|--------------------------------------|
| `chatroomId`    | integer | Yes      | The ID of the chatroom to send the message            |

**Body Parameters**

| Parameter  | Type   | Required | Description                          |
|------------|--------|----------|--------------------------------------|
| `message`    | string | Yes      | The text of the message            |
| `attachment`    | file | No      | An optional file attachment (image/video)            |

**Example Request**

```
POST /chatrooms/1/messages HTTP/1.1
Authorization: Bearer {token}
Content-Type: multipart/form-data

{
  "message": "Hello, everyone!",
  "attachment": [file] // Optional file
}
```
---
### Responses
-  __Status:__ 201 (Created)
-  __Description:__ Message sent successfully.
-  __Body:__

```json
{
  "id": 1,
  "chatroom_id": 1,
  "user_id": 1,
  "message": "Hello, everyone!",
  "attachment_path": "root/picture/example.jpg",
  "created_at": "2024-11-02T12:00:00.000000Z",
  "updated_at": "2024-11-02T12:00:00.000000Z"
}
```
---
* __Status:__ 400 (Bad Request)
* __Description:__ Validation errors occur when the request parameters do not meet the specified requirements.
* __Body:__

```json
{
  "errors": {
    "message": ["The message field is required."],
    "attachment": ["The attachment must be a file."]
  }
}
```
---
## List Messages API

#### Endpoint: Retrieve Messages from a Chatroom

- **URL**: `https://whatsapp-api-clone.umairsaif.net/api/chatrooms/{chatroomId}/messages`
- **Endpoint**: `/chatrooms/{chatroomId}/messages`
- **Method**: `GET`
- **Description**: Retrieves all messages from a specified chatroom, including full URLs for any attachments.

---

### Request

**Headers**

- `Authorization`: `Bearer {token}`

**Path Parameters**

| Parameter  | Type   | Required | Description                          |
|------------|--------|----------|--------------------------------------|
| `chatroomId`    | integer | Yes      | The ID of the chatroom to retrieve messages from.            |

**Example Request**

```
GET /chatrooms/1/messages HTTP/1.1
Authorization: Bearer {token}
```
---
### Responses
-  __Status:__ 200 (OK)
-  __Description:__ Successfully retrieved the list of messages.
-  __Body:__

```json
[
  {
    "id": 1,
    "chatroom_id": 1,
    "user_id": 1,
    "message": "Hello, everyone!",
    "attachment_path": "root/picture/example.jpg",
    "attachment_url": "https://whatsapp-api-clone.umairsaif.com/storage/root/picture/example.jpg",
    "created_at": "2024-11-02T12:00:00.000000Z",
    "updated_at": "2024-11-02T12:00:00.000000Z",
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "johndoe@example.com"
    }
  },
  {
    "id": 2,
    "chatroom_id": 1,
    "user_id": 2,
    "message": "Hi, John!",
    "attachment_path": null,
    "created_at": "2024-11-02T12:01:00.000000Z",
    "updated_at": "2024-11-02T12:01:00.000000Z",
    "user": {
      "id": 2,
      "name": "Jane Doe",
      "email": "janedoe@example.com"
    }
  }
]
```
---
* __Status:__ 404 (Not Found)
* __Description:__ The specified chatroom does not exist.
* __Body:__

```json
{
  "message": "Chatroom not found"
}
```
