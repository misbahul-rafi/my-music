from flask import Flask
from controllers import index, create_song, get_song, get_lyrics, get_thumbnail, delete_song, update_song, download_song
from flask_cors import CORS

app = Flask(__name__)
CORS(app)
@app.route('/test', methods=['POST'])
def test():
    return "Test"

@app.route('/')
def home():
    return index()

@app.route('/songs', methods=['POST'])
def songs():
    return create_song()

@app.route('/songs', methods=['PUT'])
def putSongs():
    return update_song()
    
@app.route('/songs', methods=['GET'])
def getSong():
    return get_song()

@app.route('/thumbnails', methods=['GET'])
def getThumbnail():
    return get_thumbnail()

@app.route('/lyrics', methods=['GET'])
def getLyrics():
    return get_lyrics()

@app.route('/songs', methods=['DELETE'])
def delete():
    return delete_song()

@app.route('/download', methods=['POST'])
def download():
    return download_song();

if __name__ == '__main__':
    app.run(debug=True)
