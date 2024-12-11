import { useRef, MouseEventHandler } from "react";
import { FaMinusCircle } from "react-icons/fa";

interface ConfirmProps {
  title: string,
  message: string,
  onTrue: (event: React.MouseEvent<HTMLElement>) => void,
  onClose: (event: React.MouseEvent<HTMLElement>) => void
}
const ConfirmDialog = ({ title, message, onTrue, onClose }: ConfirmProps) => {
  const overlay = useRef<HTMLDivElement>(null)

  const close: MouseEventHandler<HTMLDivElement> = (e) => {
    if (e.target === overlay.current) {
      onClose(e)
    }
  }

  return (
    <div ref={overlay} onClick={close} className="fixed top-0 right-0 bottom-0 left-0 z-50">
      <div>
        <div className="mt-36 mx-auto w-96 pb-2 bg-[#444] rounded-lg">
          <section className="text-center">
            <p>{title}</p>
          </section>
          <section className="flex items-center bg-[#333] px-5 py-5 justify-between">
            <FaMinusCircle size={60} />
            <p>{message}</p>
          </section>
          <section className="flex gap-1 justify-end px-5 pt-1">
            <button className="bg-[#222] w-20 rounded" onClick={onClose}>Cancel</button>
            <button className="bg-[#222] w-20 rounded" onClick={onTrue}>Yes</button>
          </section>
        </div>
      </div>
    </div>
  )
}
export default ConfirmDialog