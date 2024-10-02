document.addEventListener('DOMContentLoaded', () => {
    const selectTags = new Set();
    const selectTagsInput = document.getElementById('selected-tags');
    const tagBtn = document.querySelectorAll('.tag__btn');

    tagBtn.forEach(button => {
        button.addEventListener('click', () => {
            const tagId = button.getAttribute('data-tag-id');

            if (selectTags.has(tagId)) {
                selectTags.delete(tagId);
                button.classList.remove('selected');
            } else {
                selectTags.add(tagId);
                button.classList.add('selected');
            }

            selectTagsInput.value = Array.from(selectTags).join(', ');
            console.log(selectTagsInput.value);
        });
    });
});