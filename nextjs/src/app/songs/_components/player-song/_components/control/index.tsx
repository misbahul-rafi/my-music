import { MdSkipPrevious, MdPlayArrow, MdSkipNext, MdPause } from "react-icons/md";


interface ControlProps {
  isPlaying: boolean,
  handlePlayPause: (event: React.MouseEvent<HTMLElement>) => void
}

const Control = ({isPlaying, handlePlayPause}: ControlProps) => {
  return (
    <div className="flex justify-around w-full">
      <MdSkipPrevious size={60} onClick={() => console.log("Prev")} />
      <div onClick={handlePlayPause}>
        {isPlaying ? <MdPause size={60} /> : <MdPlayArrow size={60} />}
      </div>
      <MdSkipNext size={60} onClick={() => console.log("Next")} />
    </div>
  )
}

export default Control