import axios from 'axios'
export const mixin = {
    data: () =>({
        count: 0,
        loaded: false
    }),
    methods:{
        async fetchCount(status){
            var {data} = await axios({
                url: '/api/reporting/recruiter/application/count',
                method: 'get',
                params:{status:status}
            })
            this.loaded = true;
            this.count = data.count;
        }
    }
}