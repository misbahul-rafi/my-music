import os
from flask import jsonify, request, send_file
import time
import os
import re
from tools import save_thumbnail, save_lyrics, save_audio, ensure_directory_exists, fetch_video_metadata, save_audioMP3


def index():
    return "Hello from Controller!"

def download_song():
    title = request.json.get('title')
    youtubeUrl = request.json.get('youtubeUrl')
    if not youtubeUrl:
        return jsonify({'message': 'Youtube URL Not Found'}), 400
    if not title:
        return jsonify({'message': 'Title Not Found'}), 400
    
    youtube_youtubeUrl_pattern = r'^(https?://)?(www\.)?(youtube\.com|youtu\.be)/.+$'
    if not re.match(youtube_youtubeUrl_pattern, youtubeUrl):
        return jsonify({'message': 'Youtube URL Not Valid'}), 400
    
    audio_path = os.path.join('data/downloads/', f'{title}')
    ensure_directory_exists('data/downloads/')
    try:
        metadata = fetch_video_metadata(youtubeUrl)
        duration = metadata.get('duration')
        thumbnail_youtubeUrl = metadata.get('thumbnail')
        if not duration or duration > 420:
            return jsonify({'message': 'Audio duration exceeds 7 minutes'}), 400
        
        save_audioMP3(youtubeUrl, audio_path)

        return jsonify({
            'message': 'Audio and lyrics downloaded successfully',
            'title': title,
            'duration': duration,
        }), 200

    except Exception as e:
        print('Error while downloading audio:', e)
        return jsonify({"error": str(e)}), 500
    
    
    
def create_song():
    youtubeUrl = request.json.get('youtubeUrl')
    userId = request.json.get('userId')
    textLyrics = request.json.get('textLyrics')
    

    if not youtubeUrl:
        return jsonify({'message': 'Youtube URL Not Found'}), 400
    if not userId:
        return jsonify({'message': 'No User Authenticated'}), 400

    youtube_youtubeUrl_pattern = r'^(https?://)?(www\.)?(youtube\.com|youtu\.be)/.+$'
    if not re.match(youtube_youtubeUrl_pattern, youtubeUrl):
        return jsonify({'message': 'Youtube URL Not Valid'}), 400

    file_name = f'{userId}-{int(time.time())}'
    audio_path = os.path.join('data/songs/', f'{file_name}.wav')
    thumbnail_path = os.path.join('data/thumbnails/', f'{file_name}.jpg')
    lyrics_path = os.path.join('./data/lyrics/', f"{file_name}.lrc")

    ensure_directory_exists('data/songs/')
    ensure_directory_exists('data/thumbnails/')
    ensure_directory_exists('data/lyrics/')

    try:
        metadata = fetch_video_metadata(youtubeUrl)
        duration = metadata.get('duration')
        thumbnail_youtubeUrl = metadata.get('thumbnail')
        if not duration or duration > 420:
            return jsonify({'message': 'Audio duration exceeds 7 minutes'}), 400
        
        save_audio(youtubeUrl, audio_path)

        if thumbnail_youtubeUrl:
            save_thumbnail(thumbnail_youtubeUrl, thumbnail_path)

        if textLyrics:
            save_lyrics(textLyrics, lyrics_path)

        return jsonify({
            'message': 'Audio and lyrics downloaded successfully',
            'file_name': file_name,
            'duration': duration,
            'thumbnail_name': f'{file_name}.jpg'
        }), 200

    except Exception as e:
        print('Error while downloading audio:', e)
        return jsonify({"error": str(e)}), 500
    

def update_song():
    file_name = request.form.get('fileName')
    textLyrics = request.form.get('textLyrics')
    imgThumbnail = request.files.get('thumbnail')
    print(file_name)
    if(not file_name):
        return jsonify({"error": "Songs Not Found"})
    if(not (textLyrics or imgThumbnail)):
        return "No Fill To Update",200
    
    if(textLyrics):
        lyrics_path = os.path.join('data/lyrics/', f'{file_name}.lrc')
        if textLyrics:
            try:
                save_lyrics(textLyrics, lyrics_path)
            except Exception as e:
                return jsonify({"error": f"Failed to update lyrics: {str(e)}"}), 500
            
    if imgThumbnail:
        if imgThumbnail.filename.lower().endswith('.jpg'):
            thumbnail_path = os.path.join('data/thumbnails/', f'{file_name}.jpg')
            try:
                with open(thumbnail_path, 'wb') as f:
                    f.write(imgThumbnail.read())
            except Exception as e:
                return jsonify({"error": f"Failed to update thumbnail: {str(e)}"}), 500
        else:
            return jsonify({"error": "Thumbnail file must be in .jpg format"}), 400

    return jsonify({
        "message": "Song updated successfully",
        "file_name": file_name,
    }), 200

def get_song():
    file_name = request.args.get('fileName') + '.wav'
    print(file_name)

    file_path = os.path.join('data/songs/', file_name)

    print(file_path)
    if os.path.exists(file_path):
        print("File Dikirim")
        return send_file(file_path, as_attachment=False, download_name=file_name)
    else:
        return 'File Not Found', 404


def get_lyrics():
    fileName = request.args.get('fileName') + '.lrc'
    print(fileName)
    file_path = os.path.join('data/lyrics/', fileName)

    if not os.path.exists(file_path):
        return 'File LRC Not Found', 404
    return send_file(file_path)


def get_thumbnail():
    fileName = request.args.get('fileName') + '.jpg'
    file_path = os.path.join('data/thumbnails/', fileName)
    print(fileName)
    if not os.path.exists(file_path):
        return 'Thumbnail Not Found', 404
    return send_file(file_path)


def delete_song():
    file_name = request.json.get('fileName')
    if not file_name:
        return jsonify({"error": "Nama file tidak disediakan"}), 400

    files_deleted = []

    lyrics_path = os.path.join("./data/lyrics", file_name + ".lrc")
    if os.path.exists(lyrics_path):
        os.remove(lyrics_path)
        files_deleted.append(lyrics_path)

    thumbnail_path = os.path.join("./data/thumbnails", file_name + ".jpg")
    if os.path.exists(thumbnail_path):
        os.remove(thumbnail_path)
        files_deleted.append(thumbnail_path)

    song_path = os.path.join("./data/songs", file_name + ".wav")
    if os.path.exists(song_path):
        os.remove(song_path)
        files_deleted.append(song_path)

    return jsonify({"message": "File Deleted", "files_deleted": files_deleted}), 200
