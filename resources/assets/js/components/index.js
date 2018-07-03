import Vue from 'vue'
import Card from './Card'
import Child from './Child'
import Button from './Button'
import Checkbox from './Checkbox'
import LineInput from './LineInput'
import EllipsisText from './EllipsisText'
import SkillIcon from './SkillIcon'
import InfoPreview from './InfoPreview'
import PhotoViewer from './PhotoViewer'
import OpeningCard from './OpeningCard'
import PhotoConverter from './PhotoConverter'
import { HasError, AlertError, AlertSuccess } from 'vform'

// Components that are registered globaly.
[
  Card,
  Child,
  Button,
  Checkbox,
  HasError,
  LineInput,
  EllipsisText,
  AlertError,
  SkillIcon,
  InfoPreview,
  PhotoViewer,
  OpeningCard,
  PhotoConverter,
  AlertSuccess
].forEach(Component => {
  Vue.component(Component.name, Component)
})
