import { defineEmits, ref } from 'vue';

export function useValidation(){

    const emit = defineEmits(['update:address', 'submit', 'destroy']);
    
    /**
     * This contains the whole el-form. Needed for the validation.
     */
    const elFormRef = ref();
    const inputRequiredRule = ref({ required: true, message: 'Please fill this field.', trigger: 'blur' });
    const selectRequiredRule = ref({ required: true, message: 'Please select an option.', trigger: 'change' });
    const dateRequiredRule = ref({ required: true, message: 'Please select a date.', trigger: 'change' });

    /**
     * The validation rules for the form.
     */
    // const rules = reactive({
    //     first_name: [
    //         { required: true, message: 'Please fill this field.', trigger: 'blur' },
    //     ],
    // })

    /**
     * Does the frontend validation, and if it is OK, then calls the submit() function.
     */
    const validate = async (elFormRef) => {
        console.log('submit() called, FE validation starts')
        if (!elFormRef) return;

        await elFormRef.validate((valid, fields) => {
            console.log('FE validation finished, valid: ', valid)
            if (valid) {
                //if validation is OK, then submit
                console.log('FE validation OK, submit!', fields)
                emit('submit');

            } else {
                //if validation is not OK, then log the errors
                console.log('FE validation not OK, error submit!', fields)
            }
        })
    }

}

