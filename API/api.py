import requests
import argparse

webhook_url = "https://your-site/api/message.html"
token = "RandomToken"

parser = argparse.ArgumentParser(description="Process a message.")
parser.add_argument('-m', type=str, help="The message to process", required=True)
parser.add_argument('-mode', type=str, help="The message to process", required=False)
args = parser.parse_args()
message = args.m
mode = args.mode
#Modes notification important error
def send_data(): 
    data = f"{message}"
    headers = {
        "Content-Type": "text/html",
        "Authorization": f"{token}",
        "Mode": f"{mode}"
    }
    response = requests.post(webhook_url, data=data, headers=headers)
    
    if response.status_code == 200:
        # Print the response text
        print("Response Text:")
        print(response.text)  # This is the raw content of the response
    else:
        print(f"Failed to get a valid response. Status code: {response.status_code}")
        
if __name__ == "__main__": 
    send_data()
    
