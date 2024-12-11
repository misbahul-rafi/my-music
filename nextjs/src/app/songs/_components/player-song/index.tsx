'use client'
import { useEffect, useRef, useState } from 'react';
import Thumbnail from './_components/thumbnail';
import SeekBar from './_components/seek-bar';
import Control from './_components/control';
import Duration from './_components/duration';
import { Song } from '@/types'

interface props {
  song: Song,
  textLyrics: string
}

const PlayerSong = ({ song, textLyrics }: props) => {
  const audioRef = useRef<HTMLAudioElement | null>(null);
  const [lyricsDisplayed, setLyricsDisplayed] = useState<string>('');
  const [currentTime, setCurrentTime] = useState<number>(0);
  const [isPlaying, setIsPlaying] = useState<boolean>(true);

  useEffect(() => {
    const isValidLRC = (lyrics: string) => {
      const lrcPattern = /^\[(\d{2}):(\d{2})\.(\d{2})\].+/;
      return lyrics.split('\n').some(line => lrcPattern.test(line));
    };

    if (textLyrics && isValidLRC(textLyrics)) {
      const lines = textLyrics.split('\n');
      const parsedLyrics: { time: number; text: string }[] = [];

      lines.forEach(line => {
        if (/\[(id|ar|al|ti|length):/.test(line)) {
          return;
        }

        const lyricMatch = line.match(/\[(\d{2}):(\d{2})\.(\d{2})\](.*)/);
        if (lyricMatch) {
          const minutes = parseInt(lyricMatch[1]);
          const seconds = parseInt(lyricMatch[2]);
          const milliseconds = parseInt(lyricMatch[3]);
          const text = lyricMatch[4].trim();
          parsedLyrics.push({
            time: minutes * 60 + seconds + milliseconds / 100,
            text: text,
          });
        }
      });

      const updateLyrics = () => {
        if (audioRef.current) {
          const currentTime = audioRef.current.currentTime;
          const currentLine = parsedLyrics.find((line, index) => {
            return (
              line.time <= currentTime &&
              (!parsedLyrics[index + 1] || parsedLyrics[index + 1].time > currentTime)
            );
          });
          setLyricsDisplayed(currentLine ? currentLine.text : '');
        }
      };

      const audioElement = audioRef.current;
      audioElement?.addEventListener('timeupdate', updateLyrics);
      return () => {
        audioElement?.removeEventListener('timeupdate', updateLyrics);
      };
    } else {
      setLyricsDisplayed("No Lyrics Available or Invalid Format");
    }

    console.log(textLyrics);
  }, [textLyrics]);


  const handlePlayPause = () => {
    if (audioRef.current) {
      if (isPlaying) {
        audioRef.current.pause();
      } else {
        audioRef.current.play();
      }
      setIsPlaying(!isPlaying);
    }
  };

  const handleSeek: React.MouseEventHandler = (e: React.MouseEvent<HTMLDivElement>) => {
    if (audioRef.current) {
      const width = e.currentTarget.clientWidth;
      const clickX = e.nativeEvent.offsetX;
      const duration = audioRef.current.duration;
      audioRef.current.currentTime = (clickX / width) * duration;
    }
  };

  return (
    <div className=''>

      <Thumbnail fileName={song.fileName} lyrics={lyricsDisplayed} />

      <div className='px-4'>
        <h1 className='text-3xl font-bold text-center w-full'>{song.title}</h1>
        <Control isPlaying={isPlaying} handlePlayPause={handlePlayPause} />
        <SeekBar currentTime={currentTime} duration={song.duration} handleSeek={handleSeek} />
        <Duration currentDuration={currentTime} duration={song.duration} />
      </div>

      <audio
        ref={audioRef} id="audioPlayer" hidden autoPlay
        onTimeUpdate={() => setCurrentTime(audioRef.current?.currentTime || 0)}
      >
        <source src={`${process.env.NEXT_PUBLIC_FLASK_API}/songs?fileName=${song.fileName}`} type="audio/mpeg" />
        Your browser does not support the audio element.
      </audio>
    </div>
  )
}
export default PlayerSong