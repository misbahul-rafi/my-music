
interface SeekBarProps{
  handleSeek: (event: React.MouseEvent<HTMLElement>) => void,
  currentTime: number,
  duration: number

}
const SeekBar = ({handleSeek, currentTime, duration}: SeekBarProps) => {

  return (
    <section id="seekContainer" className="mt-4 relative w-full h-2 bg-gray-300 rounded-full" onClick={handleSeek}>
      <div
        id="nowDurations"
        className="h-2 bg-[#005B41] rounded-full"
        style={{ width: `${(currentTime / duration) * 100}%`, position: 'absolute', top: 0, left: 0 }}
      />
    </section>
  )
}
export default SeekBar