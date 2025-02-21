<div class="tag-manager mb-4">
    <div class="d-flex flex-wrap gap-2 mb-2">
        @foreach($tags as $tag)
            <span class="badge bg-primary d-flex align-items-center">
                {{ $tag }}
                <button type="button" class="btn-close btn-close-white ms-2" 
                        onclick="removeTag(this, '{{ $tag }}')" style="font-size: 0.5em;">
                </button>
            </span>
        @endforeach
    </div>
    
    <div class="input-group">
        <input type="text" class="form-control" id="tagInput" placeholder="Add tag and press Enter"
               onkeydown="handleTagInput(event)">
        <button class="btn btn-outline-primary" type="button" onclick="addTag()">
            <i class="fas fa-plus"></i>
        </button>
    </div>
    <input type="hidden" name="tags" id="tagsInput" value="{{ implode(',', $tags) }}">
</div>

<script>
    function handleTagInput(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            addTag();
        }
    }

    function addTag() {
        const input = document.getElementById('tagInput');
        const tag = input.value.trim();
        
        if (tag) {
            const tagsContainer = input.parentElement.previousElementSibling;
            const tagsInput = document.getElementById('tagsInput');
            const currentTags = tagsInput.value ? tagsInput.value.split(',') : [];
            
            if (!currentTags.includes(tag)) {
                const tagElement = document.createElement('span');
                tagElement.className = 'badge bg-primary d-flex align-items-center';
                tagElement.innerHTML = `
                    ${tag}
                    <button type="button" class="btn-close btn-close-white ms-2" 
                            onclick="removeTag(this, '${tag}')" style="font-size: 0.5em;">
                    </button>
                `;
                
                tagsContainer.appendChild(tagElement);
                currentTags.push(tag);
                tagsInput.value = currentTags.join(',');
            }
            
            input.value = '';
        }
    }

    function removeTag(button, tag) {
        const tagsInput = document.getElementById('tagsInput');
        const currentTags = tagsInput.value.split(',');
        const index = currentTags.indexOf(tag);
        
        if (index > -1) {
            currentTags.splice(index, 1);
            tagsInput.value = currentTags.join(',');
            button.parentElement.remove();
        }
    }
</script>
