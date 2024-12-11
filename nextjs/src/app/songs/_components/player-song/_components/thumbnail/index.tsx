
interface ThumbnailProps {
  fileName: string,
  lyrics: string
}
const Thumbnail = ({ fileName, lyrics}: ThumbnailProps) => {

  return (
    <section className='relative'>
      <div id='thumbnail' className="w-full h-[424px] rounded-lg" style={{ backgroundImage: `url(${process.env.NEXT_PUBLIC_FLASK_API}/thumbnails?fileName=${fileName})` }} />
      <div id="lyrics" className='rounded-lg'>
        <p className='text-white'>{lyrics}</p>
      </div>
    </section>
  )
}

export default Thumbnail