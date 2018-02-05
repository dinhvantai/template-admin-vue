<template>
      <slider animation="fade">
            <p style="line-height: 280px; font-size: 5rem; text-align: center;" v-if="!list.length">Loading...</p>
            <slider-item v-for="(i, index) in list" :key="index" :on-click="test">
                <a href="/adfasfs">
                    <img src="http://lorempixel.com/735/280/" alt="">                
                </a>
            </slider-item>
        </slider>
</template>

<script>
import { Slider, SliderItem } from 'vue-easy-slider'

export default {
    name: 'user-slider',

    components: { 'slider': Slider, 'slider-item': SliderItem },
    methods: {
        test () {console.log(1)}
    },
    data () {
        return {
            list: [
            ]
        }
    },

    mounted () {
        setTimeout(() => {
            this.list = [
                { backgroundColor: '#3f51b5', width: '100%', height: '100%' },
                { backgroundColor: '#eee', width: '100%', height: '100%' },
                { backgroundColor: '#f44336', width: '100%', height: '100%' },
            ]
        }, 1000)
  },
}
</script>

