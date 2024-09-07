<div>
    <div x-data="sampleData()">

        <div class="px-2 py-1 bg-green-500 text-white uppercase">

            <template x-for="role in roles" :key="role">
                <div class="flex justify-between mb-2 w-1/2">
                    <div x-text="role.name">

                    </div>
                    <div>
                        <x-button type="button" @click="addToA" >Add to a</x-button>
                    </div>
                </div>
            </template>
        </div>
        <div class="px-2 py-1 bg-green-300 text-white">

            <template x-for="(text, index) in array">
                <div class="flex justify-between mb-2 w-1/2">

                    <div x-text="text.name"></div>
                    <div x-text="text.points"></div>
                    <div>
                        <x-button type="button" @click="removeToA(index)">Remove to a</x-button>
                    </div>
                </div>
            </template>

        </div>
        <x-button type="button" @click="submit()">Submit</x-button>
    </div>
</div>

<script>
    function sampleData()
    {
        return {
            roles: @entangle('arrays'),
            array: @entangle('a').defer ,
            addToA(e) {
                console.log(e.target)
                // var object_json = JSON.parse(val)
                // var name = object_json['name']
                // var points = Math.floor( Math.random() * 100 )
                // console.log(name)
                // a = {
                //     'name' : name,
                //     'points' : points
                // }
                // this.array.push(a)


            },
            removeToA(i) {
                this.array.splice(i, 1)
            },
            submit() {
                Livewire.emit('submit')
            }


        }
    }
</script>
