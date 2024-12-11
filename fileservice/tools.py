import os
import subprocess
import os
import json
import requests


def save_thumbnail(thumbnail_url, output_path):
    response = requests.get(thumbnail_url)
    if response.status_code == 200:
        with open(output_path, 'wb') as f:
            f.write(response.content)
    return response.status_code == 200


def ensure_directory_exists(path):
    if not os.path.exists(path):
        os.makedirs(path)


def save_lyrics(text_lyrics, output_path):
    clean_lyrics = text_lyrics.replace('\r\n', '\n').strip()
    with open(output_path, 'w', encoding='utf-8', newline='\n') as file:
        file.write(clean_lyrics)
    return output_path


def save_audio(url, output_path):
    subprocess.run([
        'yt-dlp', '-x', '--audio-format', 'wav', url,
        '-o', output_path,
        # '--ffmpeg-location', './ffmpeg/bin/ffmpeg.exe'
    ], check=True)
def save_audioMP3(url, output_path):
    subprocess.run([
        'yt-dlp', '-x', '--audio-format', 'mp3', url,
        '-o', output_path,
        # '--ffmpeg-location', './ffmpeg/bin/ffmpeg.exe'
    ], check=True)


def fetch_video_metadata(url):
    result = subprocess.run(['yt-dlp', '-j', url],
                            capture_output=True, text=True, check=True)
    return json.loads(result.stdout)
