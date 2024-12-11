// @components/Modal/page.tsx
'use client'

import { useRouter } from "next/navigation"
import { MouseEventHandler, useRef, ReactNode } from "react"

interface ModalProps{
  children: ReactNode
}

const Modal = ({ children }: ModalProps) => {
  const overlay = useRef(null)
  const router = useRouter();

  const close: MouseEventHandler = (e) => {
    if (e.target === overlay.current) {
      router.back()
    }
  }
  return (
    <div ref={overlay} className="modal" onClick={close}>
      <div className="w-max mx-auto">
        {children}
      </div>
    </div>
  )
}

export default Modal