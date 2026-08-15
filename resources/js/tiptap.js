import { Editor } from '@tiptap/core'
import StarterKit from '@tiptap/starter-kit'

class TiptapEditor {
    constructor(element, wire, property) {

        this.editor = new Editor({
            element,

            extensions: [
                StarterKit,
            ],

            content: wire[property] ?? '',

            onUpdate: ({ editor }) => {
                wire.$set(property, editor.getHTML())
            },
        })
    }
}

window.TiptapEditor = TiptapEditor
