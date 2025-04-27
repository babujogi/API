# Simple PHP System with API

## Description
A simple system for:
- User login via token,
- Displaying server log files,
- Receiving messages through an API (authorization via HTTP header).

## Features
- **Login:**  
  Access the page and enter the token (`1qazxsw2`) to log in.

- **Logout:**  
  Click the `Logout` button to end the session.

- **Log viewing:**  
  Logs are stored in the `log/` folder in the format `YYYY-MM-DD-message.log`.  
  You can view a specific date by adding a `?date=YYYY-MM-DD` parameter to the URL.

- **Automatic refresh:**  
  The page automatically refreshes every 30 seconds.  
  You can stop the countdown by clicking the `Stop Refresh` button or when using a specific date.

- **Message receiving API:**  
  - Endpoint: `POST https://your-website.com/api/message.html`
  - Requires the correct `Authorization` token in the header.
  - Accepts additional headers like `Mode` (`notification`, `important`, `error`).
  - If the token is invalid, the attempt is logged as an error.

## Python Script (`send_message.py`)
- Used to send messages to the server.
- Usage:
  ```bash
  python send_message.py -m "Your message" -mode notification
