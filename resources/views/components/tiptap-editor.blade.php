@props(['initialContent' => ''])

<div wire:ignore class="w-full">
    <div
        id="templateEditorToolbar"
        class="flex flex-wrap items-center gap-1 p-2 border border-b-0 border-gray-300 dark:border-gray-600 rounded-t-lg bg-gray-50 dark:bg-gray-700"
    ></div>
    <div
        id="templateEditor"
        class="w-full px-4 py-2 text-sm sm:text-base border border-gray-300 dark:border-gray-600 rounded-b-lg focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 min-h-[300px] [&_.tiptap]:min-h-[280px] [&_.tiptap]:outline-none [&_.tiptap_p]:my-2 [&_.tiptap_h1]:text-2xl [&_.tiptap_h1]:font-bold [&_.tiptap_h2]:text-xl [&_.tiptap_h2]:font-bold [&_.tiptap_h3]:text-lg [&_.tiptap_h3]:font-semibold [&_.tiptap_ul]:list-disc [&_.tiptap_ul]:pl-6 [&_.tiptap_ol]:list-decimal [&_.tiptap_ol]:pl-6"
    ></div>
</div>

<script>
    window.__templateInitialContent = @json($initialContent);
</script>

<script type="module">
    (function () {
        const el = document.getElementById('templateEditor');
        if (!el || el._tiptapInitialized) return;

        const initial = window.__templateInitialContent ?? '';

        import('https://esm.sh/@tiptap/core').then(({ Editor }) => {
            return Promise.all([
                import('https://esm.sh/@tiptap/starter-kit'),
                import('https://esm.sh/@tiptap/extension-text-align'),
            ]).then(([{ default: StarterKit }, { TextAlign }]) => {
                const editor = new Editor({
                    element: el,
                    extensions: [
                        StarterKit,
                        TextAlign.configure({ types: ['heading', 'paragraph'] }),
                    ],
                    content: initial,
                    editorProps: {
                        attributes: {
                            class: 'tiptap',
                        },
                    },
                });

                el._tiptapInitialized = true;
                el._tiptapEditor = editor;

                const toolbar = document.getElementById('templateEditorToolbar');
                const btnClass = 'p-2 rounded text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500';
                const btnActiveClasses = ['bg-gray-300', 'dark:bg-gray-600'];

                const buttons = [
                    { title: 'Bold', icon: 'fa-bold', onClick: () => editor.chain().focus().toggleBold().run(), isActive: () => editor.isActive('bold') },
                    { title: 'Italic', icon: 'fa-italic', onClick: () => editor.chain().focus().toggleItalic().run(), isActive: () => editor.isActive('italic') },
                    { title: 'Strikethrough', icon: 'fa-strikethrough', onClick: () => editor.chain().focus().toggleStrike().run(), isActive: () => editor.isActive('strike') },
                    { title: 'Code', icon: 'fa-code', onClick: () => editor.chain().focus().toggleCode().run(), isActive: () => editor.isActive('code') },
                    { type: 'separator' },
                    { title: 'Heading 1', text: 'H1', onClick: () => editor.chain().focus().toggleHeading({ level: 1 }).run(), isActive: () => editor.isActive('heading', { level: 1 }) },
                    { title: 'Heading 2', text: 'H2', onClick: () => editor.chain().focus().toggleHeading({ level: 2 }).run(), isActive: () => editor.isActive('heading', { level: 2 }) },
                    { title: 'Heading 3', text: 'H3', onClick: () => editor.chain().focus().toggleHeading({ level: 3 }).run(), isActive: () => editor.isActive('heading', { level: 3 }) },
                    { type: 'separator' },
                    { title: 'Bullet list', icon: 'fa-list-ul', onClick: () => editor.chain().focus().toggleBulletList().run(), isActive: () => editor.isActive('bulletList') },
                    { title: 'Numbered list', icon: 'fa-list-ol', onClick: () => editor.chain().focus().toggleOrderedList().run(), isActive: () => editor.isActive('orderedList') },
                    { title: 'Blockquote', icon: 'fa-quote-right', onClick: () => editor.chain().focus().toggleBlockquote().run(), isActive: () => editor.isActive('blockquote') },
                    { type: 'separator' },
                    { title: 'Align left', icon: 'fa-align-left', onClick: () => editor.chain().focus().setTextAlign('left').run(), isActive: () => editor.isActive({ textAlign: 'left' }) },
                    { title: 'Align center', icon: 'fa-align-center', onClick: () => editor.chain().focus().setTextAlign('center').run(), isActive: () => editor.isActive({ textAlign: 'center' }) },
                ];

                function updateToolbarState() {
                    toolbar.querySelectorAll('button[data-tiptap-btn]').forEach((btn) => {
                        const isActive = btn._isActive && btn._isActive();
                        btnActiveClasses.forEach((c) => btn.classList.toggle(c, isActive));
                        btn.setAttribute('aria-pressed', isActive);
                    });
                }

                buttons.forEach((b) => {
                    if (b.type === 'separator') {
                        const sep = document.createElement('span');
                        sep.className = 'w-px h-5 bg-gray-300 dark:bg-gray-600 mx-1';
                        toolbar.appendChild(sep);
                        return;
                    }
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.setAttribute('data-tiptap-btn', '');
                    btn.className = btnClass;
                    btn.title = b.title;
                    btn.setAttribute('aria-label', b.title);
                    if (b.icon) {
                        const i = document.createElement('i');
                        i.className = `fa-solid ${b.icon}`;
                        btn.appendChild(i);
                    } else if (b.text) {
                        btn.textContent = b.text;
                        btn.classList.add('text-xs', 'font-semibold');
                    }
                    btn._isActive = b.isActive;
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();
                        b.onClick();
                        updateToolbarState();
                    });
                    toolbar.appendChild(btn);
                });

                editor.on('selectionUpdate', updateToolbarState);
                editor.on('transaction', updateToolbarState);
                updateToolbarState();

                function syncToLivewire() {
                    const root = el.closest('[wire\\:id]');
                    if (root && window.Livewire) {
                        const id = root.getAttribute('wire:id');
                        if (id) {
                            const component = window.Livewire.find(id);
                            if (component) component.set('template', editor.getHTML());
                        }
                    }
                }

                editor.on('update', syncToLivewire);

                const form = el.closest('form');
                if (form) form.addEventListener('submit', syncToLivewire);
            });
        });
    })();
</script>
