import {
    HideModal,
    closeAndConfirmModal,
    closeModal,
    goPreviousPage
} from "./fonction.js"
import { 
    submit,
    confirmerBtn,
    closeIcon,
    annulerBtn,
    arrow
} from "./object.js"



export const modalEvents = [
    submit.addEventListener("click",HideModal),
    confirmerBtn.addEventListener("click",closeAndConfirmModal),
    closeIcon.addEventListener("click",closeModal),
    annulerBtn.addEventListener("click",closeModal)
]
export const arrowEvents = arrow.addEventListener("click", goPreviousPage);