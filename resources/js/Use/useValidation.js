export function useValidation(elFormRef){
  

    /**
     * The validation rules for the form.
     */
    const rules = reactive({
        first_name: [
            { required: true, message: 'Please fill this field.', trigger: 'blur' },
        ],
    })

    /**
     * Does the frontend validation, and if it is OK, then calls the submit() function.
     */
    const doFrontendValidation = async (elFormRef) => {
        console.log('submit() called, FE validation starts')
        if (!elFormRef) return;

        await elFormRef.validate((valid, fields) => {

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

