/* JavaScript untuk memotong teks pada tampilan mobile */
document.addEventListener("DOMContentLoaded", function () {
    const paragraph = document.getElementById("organizationDescription");
    const words = paragraph.innerText.split(" ");
    const showMoreButton = document.getElementById("showMoreButton");

    if (window.innerWidth <= 600 || window.innerWidth <= 995) {
        if (words.length > 50) {
            const first50Words = words.slice(0, 50).join(" ") + "...";
            const remainingWords = words.slice(50).join(" ");

            paragraph.innerHTML = `${first50Words}<span class="more-text"> ${remainingWords}</span>`;
            showMoreButton.style.display = "inline";
        } else {
            showMoreButton.style.display = "none";
        }
    } else {
        if (words.length > 100) {
            const first100Words = words.slice(0, 100).join(" ") + "...";
            const remainingWords = words.slice(100).join(" ");

            paragraph.innerHTML = `${first100Words}<span class="more-text"> ${remainingWords}</span>`;
            showMoreButton.style.display = "inline";
        } else {
            showMoreButton.style.display = "none";
        }
    }

    showMoreButton.addEventListener("click", function () {
        const moreText = document.querySelector(".more-text");
        moreText.style.display =
            moreText.style.display === "none" ? "inline" : "none";
        showMoreButton.innerText =
            moreText.style.display === "none" ? "Selengkapnya" : "Sembunyikan";
    });
});

import {
	AccessibilityHelp,
	Autoformat,
	AutoImage,
	AutoLink,
	Autosave,
	Bold,
	ClassicEditor,
	Essentials,
	Heading,
	ImageBlock,
	ImageCaption,
	ImageInsertViaUrl,
	ImageResize,
	ImageStyle,
	ImageTextAlternative,
	ImageToolbar,
	Italic,
	Link,
	LinkImage,
	List,
	ListProperties,
	Paragraph,
	SelectAll,
	Table,
	TableToolbar,
	TextTransformation,
	TodoList,
	Underline,
	Undo
} from 'ckeditor5';

const editorConfig = {
	toolbar: {
		items: [
			'undo',
			'redo',
			'|',
			'selectAll',
			'|',
			'heading',
			'|',
			'bold',
			'italic',
			'underline',
			'|',
			'link',
			// 'insertImageViaUrl',
			'insertTable',
			'|',
			'bulletedList',
			'numberedList',
			'todoList',
			'|',
			'accessibilityHelp'
		],
		shouldNotGroupWhenFull: false
	},
	plugins: [
		AccessibilityHelp,
		Autoformat,
		AutoImage,
		AutoLink,
		Autosave,
		Bold,
		Essentials,
		Heading,
		ImageBlock,
		ImageCaption,
		ImageInsertViaUrl,
		ImageResize,
		ImageStyle,
		ImageTextAlternative,
		ImageToolbar,
		Italic,
		Link,
		LinkImage,
		List,
		ListProperties,
		Paragraph,
		SelectAll,
		Table,
		TableToolbar,
		TextTransformation,
		TodoList,
		Underline,
		Undo
	],
	heading: {
		options: [
			{
				model: 'paragraph',
				title: 'Paragraph',
				class: 'ck-heading_paragraph'
			},
			{
				model: 'heading1',
				view: 'h1',
				title: 'Heading 1',
				class: 'ck-heading_heading1'
			},
			{
				model: 'heading2',
				view: 'h2',
				title: 'Heading 2',
				class: 'ck-heading_heading2'
			},
			{
				model: 'heading3',
				view: 'h3',
				title: 'Heading 3',
				class: 'ck-heading_heading3'
			},
			{
				model: 'heading4',
				view: 'h4',
				title: 'Heading 4',
				class: 'ck-heading_heading4'
			},
			{
				model: 'heading5',
				view: 'h5',
				title: 'Heading 5',
				class: 'ck-heading_heading5'
			},
			{
				model: 'heading6',
				view: 'h6',
				title: 'Heading 6',
				class: 'ck-heading_heading6'
			}
		]
	},
	image: {
		toolbar: [
			'toggleImageCaption',
			'imageTextAlternative',
			'|',
			'imageStyle:alignBlockLeft',
			'imageStyle:block',
			'imageStyle:alignBlockRight',
			'|',
			'resizeImage'
		],
		styles: {
			options: ['alignBlockLeft', 'block', 'alignBlockRight']
		}
	},
	link: {
		addTargetToExternalLinks: true,
		defaultProtocol: 'https://',
		decorators: {
			toggleDownloadable: {
				mode: 'manual',
				label: 'Downloadable',
				attributes: {
					download: 'file'
				}
			}
		}
	},
	list: {
		properties: {
			styles: true,
			startIndex: true,
			reversed: true
		}
	},
	placeholder: 'Type or paste your content here!',
	table: {
		contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
	}
};

var editor;

ClassicEditor.create(document.querySelector('#editor'), editorConfig)
	.then(editor => {
		editor = editor;
	});

