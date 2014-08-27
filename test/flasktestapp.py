import json
from flask import Flask, request, jsonify
app = Flask(__name__)

@app.route("/", methods=['GET', 'POST'])
def hello():
    if request.method == 'POST':
        return "Hello " + request.form['name']
        
    return "Hello World!"
    
@app.route("/sum", methods=['GET', 'POST', 'PUT', 'DELETE'])
def hellojson():
    if request.method == 'GET':
        x = int(request.args['x'])
        y = int(request.args['y'])
        return jsonify(result= x+y)
    else:
        x = int(request.form['x'])
        y = int(request.form['y'])
        return jsonify(result= x+y)    
    
if __name__ == "__main__":
    app.debug = True
    app.run()