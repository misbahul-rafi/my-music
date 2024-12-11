
'use client'
import ConfirmDialog from '@/components/confirm'
import { useState } from 'react'
import { MdExpandMore, MdExpandLess } from 'react-icons/md'
import { Song } from '@/types'
import FormSong from '@/app/songs/_components/form-songs'
import { useDeleteSong } from '@/utils/useSongs'
import {useRouter} from 'next/navigation'

interface props{
  song: Song,
  songLyrics?: string 
}

const Actions = ({song, songLyrics}: props) => {
  const [viewAction, setViewAction] = useState<boolean>(false)
  const [actionType, setActionType] = useState<string>('')
  const router = useRouter()
  
  const onClose = () => {
    setActionType('')
  }
  const onDeleteSuccess = () =>{
    console.log("Song Deleted")
    router.push('/songs')
  }
  const deleteMutate = useDeleteSong(onDeleteSuccess)
  const onDeletedTrue = () => {
    deleteMutate.mutate(song.id.toString())
  }


  return (
    <div className='py-3'>
      {viewAction ? (
        <MdExpandLess
          className='mx-auto hover:drop-shadow-3xl rounded-[50%] action transition-transform duration-300'
          size={50}
          onClick={() => setViewAction(!viewAction)}
        />
      ) : (
        <MdExpandMore
          className='mx-auto hover:drop-shadow-3xl rounded-[50%] action transition-transform duration-300 '
          size={50}
          onClick={() => setViewAction(!viewAction)}
        />
      )}

      {viewAction && (
        <div className='w-full flex justify-around'>
          <button className='bg-[#777] gap-3 text-center w-48 py-1 rounded-lg hover:bg-[#000]' onClick={() => setActionType('edit')}>Edit</button>
          <button className='bg-[#777] gap-3 text-center w-48 py-1 rounded-lg hover:bg-[#000]' onClick={() => setActionType('delete')}>Delete</button>
        </div>
      )}

      {actionType === 'delete' &&
        <ConfirmDialog
          title={'Songs'}
          message={'Are you sure to delete this song ?'}
          onClose={onClose}
          onTrue={onDeletedTrue}
        />
      }
      {actionType === 'edit' &&
      <FormSong song={song} onClose={onClose} songLyrics={songLyrics} />
      }
    </div>
  )
}

export default Actions