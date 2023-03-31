import {
    HideModal,
    closeAndConfirmModal,
    closeModal
} from "./fonction.js"
import { 
    submit,
    confirmerBtn,
    closeIcon,
    annulerBtn
} from "./object.js"



export const modalEvents = [
    submit.addEventListener("click",HideModal),
    confirmerBtn.addEventListener("click",closeAndConfirmModal),
    closeIcon.addEventListener("click",closeModal),
    annulerBtn.addEventListener("click",closeModal)
]