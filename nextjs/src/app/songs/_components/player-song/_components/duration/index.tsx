

interface DurationProps {
  currentDuration: number,
  duration: number
}

const Duration = ({currentDuration, duration} : DurationProps) => {

  return (
    <div className="flex justify-between text-sm mt-2">
      <span id="currentTime">{new Date(currentDuration * 1000).toISOString().substr(14, 5)}</span>
      <span id="duration">{new Date(duration * 1000).toISOString().substr(14, 5)}</span>
    </div>
  )
}

export default Duration