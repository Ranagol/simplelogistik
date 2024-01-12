<template>
  <img class="cursor-pointer mr-3" @click="toggleLanguageSwitch" :src="`/images/flags/${$i18n.locale}.svg`" :alt="key" width="30" height="20" />
  <div @focusout="toggleLanguageSwitch" class="bg-white p-3 fixed top-12 h-0 overflow-y-hidden -translate-x-2/3 min-w-[150px] rounded-md shadow-md"
    :class="{ 'hidden': !switchState, 'h-auto': switchState }">
    <div class="hoverable pt-3 relative flex flex-row-reverse" v-for="key in locales" :key="key"
      @click="$i18n.locale = key; updateLanguage()">
      <img :src="`/images/flags/${key}.svg`" :alt="key" width="30" height="20" /> <span class="pr-4"
        :class="{ 'font-bold': $i18n.locale == key }">{{ $t(`lang.${key}`) }}</span>
    </div>
  </div>
</template>
  
<script>

export default {
  name: "LanguageSwitch",
  data() {
    return {
      locales: ["de", "en", "es", "it", "fr"],
      switchState: false,
      key: null,
    };
  },
  methods: {
    updateLanguage() {
      sessionStorage.setItem("locale", this.$i18n.locale);
      this.toggleLanguageSwitch();
    },
    toggleLanguageSwitch() {
      this.switchState = !!!this.switchState;
    },
  },
  mounted() {
    if (sessionStorage.getItem("locale")) {
      this.$i18n.locale = sessionStorage.getItem("locale");
    } else {
      sessionStorage.setItem("locale", this.$i18n.locale);
    }
  },
};
</script>

<style scoped>

.hoverable:hover * {
  font-weight: bold;
  cursor: pointer;
}

</style>