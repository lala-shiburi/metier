import Vue from 'vue'
import Card from './Card'
import Child from './Child'
import Button from './Button'
import Checkbox from './Checkbox'
import LineInput from './LineInput'
import EllipsisText from './EllipsisText'
import SkillIcon from './SkillIcon'
import InfoPreview from './InfoPreview'
import OpeningCard from './OpeningCard'
import PhotoConverter from './PhotoConverter'
import IconizedPhoto from './IconizedPhoto'
import Wizard from './Wizard'
import CompanyCard from './CompanyCard'
import IconButton from './IconButton'
import UnickTable from './UnickTable'
import EntityHeader from './EntityHeader'
import UnickLoader from './loaders/roller'
import DocumentUploadInput from './input/document-upload'
import PhotoFrame from  './photo/frame'
import Logo from './Logo'
import { HasError, AlertError, AlertSuccess } from 'vform'

var mixins = {
  methods: {
    formatedDate(date, withTime){
      var _date = date.split(' ')[0].split('-');
      var _time = date.split(' ')[1].split(':');

      var months = [
        'Jan.',
        'Feb.',
        'Mar.',
        'Apr.',
        'May',
        'Jun.',
        'Jul.',
        'Aug.',
        'Sep.',
        'Oct.',
        'Nov.',
        'Dec.',
      ];

      var time = (parseInt(_time[0]) > 12 ? parseInt(_time[0]) - 1 : parseInt(_time[0])) + ':' + _time[1] + ' ' +(parseInt(_time[0]) > 11 ? 'PM' : 'Am');

      return (withTime ? time : '' ) + ' ' + months[parseInt(_date[1]) - 1] + ' ' + parseInt(_date[2]) + ', ' + parseInt(_date[0])
    }
  },
}

Vue.mixin(mixins);

// Components that are registered globally.
[
  IconButton,
  Card,
  UnickTable,
  Child,
  Button,
  EntityHeader,
  Checkbox,
  HasError,
  LineInput,
  EllipsisText,
  AlertError,
  SkillIcon,
  IconizedPhoto,
  InfoPreview,
  CompanyCard,
  OpeningCard,
  PhotoConverter,
  Wizard,
  AlertSuccess,
  UnickLoader,
  DocumentUploadInput,
  Logo,
  PhotoFrame
].forEach(Component => {
  Vue.component(Component.name, Component)
})
