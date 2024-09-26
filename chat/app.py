from flask import Flask, request, jsonify, render_template
from chatgui import chatbot_response
from flask_cors import CORS

app = Flask(__name__)
CORS(app)  # Tự động bao gồm tất cả các nguồn trong CORS

@app.route('/')
def hello_world():
    return render_template('index.html')

# Route to handle user messages and return bot responses
@app.route('/get_response', methods=['POST'])
def get_response():
    user_message = request.form['message']  # Assuming message is sent via form data
    response = chatbot_response(user_message)
    return jsonify({'response': response})

if __name__ == "__main__":
    app.run(debug=False, host='0.0.0.0', port=8000, use_reloader=False)
