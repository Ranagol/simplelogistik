<script setup>
    import { ref, reactive, onMounted } from 'vue';
    import { initFlowbite } from 'flowbite';
    
    onMounted(() => {
        initFlowbite();
    });
    
    const props = defineProps({
        config: {
            type: Object,
            required: true
        },
        onSelect: {
            type: Function,
            required: true
        },
        currentValue: {
            type: String,
            required: true
        }
    });

    var searchString = ref('');
    var currentValue = ref(props.currentValue ?? "");
    var filter = reactive({state: false});
    var _results = ref([]);
    var results = ref([]);
    
    var onSelect = (result) => {
        filter.state = false
        props.onSelect(result);
        currentValue = ref(result.name);
        results = ref([]);
    }

    const search = (e) => {
        var resource = props.config.searchResource
        searchString = ref(e.target.value);
        axios.post('/search', {
            resource: resource,
            q: e.target.value,
            giveback: props.config.resultKeys
        }).then(response => {
            results.value = response.data;
            _results.value = response.data;
        });
    }

    const defaultWrapperClass = 'relative w-full';
    const defaultLabelClass = ''
        + 'absolute '
        + 'top-0 '
        + 'start-1 '
        + 'px-2 '
        + 'text-[15px] '
        // + 'font-bold '
        // + 'peer-focus:font-bold '
        // + 'peer-placeholder-shown:font-bold '
        + '-translate-y-1/2 '
        + 'bg-white '
        + 'peer-focus:text-corporate-700 '
        + 'peer-placeholder-shown:top-1/2 '
        + 'peer-focus:top-0 '
        + 'transition-all '
        + 'duration-300 '
        + 'pointer-events-none '
        
    const defaultInputClass = ''
        + 'rounded-md ' 
        + 'w-full '
        + 'peer '
        + 'pr-8 '
        + 'text-[15px] '
        + 'text-black '
        + 'border-gray-300 '
        + 'focus:border-primary-700 '
        + 'ring-0 '
        + 'focus:ring-0 '

document.querySelector('body').addEventListener('click', function(event) {
    if (!event.target.closest('.searchable-input')) {
        filter.state = false;
    }
});

</script>

<template>
    <div @blur="() => filter.state = false" class="relative" :class="config.class">
        <div class="searchable-input" :class="defaultWrapperClass">
            <input :class="defaultInputClass" 
                @focusin="() => filter.state = true" 
                :id="config.id" 
                v-model="currentValue"
                v-on:input="search($event)"
                v-on:focusin="results = _results"
                type="search" 
                placeholder="Search..." />
            <label :for="config.id" :class="defaultLabelClass" >{{ $t(config.label) }}</label>
            <div v-if="results.length > 0" 
                    class="absolute left-0 right-0 z-50 w-full p-4 overflow-y-scroll bg-white border shadow-md text-corporate-950 top-full max-h-48" 
                    :class="{'block': filter.state, 'hidden': !filter.state}">
                <ul>
                    <li v-for="result in results" :key="result.id" class="px-4 py-2 cursor-pointer hover:bg-gray-100" @click="() => onSelect(result)">
                        {{ result.name }}
                    </li>
                </ul>
            </div>
            <div v-else 
                class="absolute left-0 right-0 z-50 w-full p-4 bg-white border shadow-md text-corporate-950 top-full" 
                :class="{'block': filter.state, 'hidden': !filter.state}">
                {{ (results.length === 0 && searchString !== '') ? $t('labels.search.no-results') : $t('labels.search.start-typing-to-search') }}
            </div>
        </div>
    </div>
</template>