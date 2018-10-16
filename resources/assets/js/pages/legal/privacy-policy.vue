<template>
  <div>
    <h1 class="display-4">Privacy Policy</h1>

    <p class="h4">About Jobseed</p>
    <p>
      Jobseed is a direct consequence of Nexseed's tireless pursuit for cultivating human resources which can help and encourage everyone to take
      an active part in battling the world's most difficult challenges by improving the lives of many. Jobseed is a software
      platform that can help applicants find jobs - with which they are fully suited - and on the other hand,
      help companies hire the best employees.
    </p>

    <p class="h4">Privacy Policy</p>
    <p>
      This privacy policy helps Nexseed inform and give awareness to users on what are the information we gather and how
      we might utilize those information. And while it is our priority to uphold secrecy, we are striving to provide each users with as much
      advantageous information to give them a bird's eye view of the best opportunities. Given that users use our Services,
      we will conclude that it is with knowledge and agreement to the privacy policy.
      Overtime, as our services improve, we might have to update this privacy policy. And this privacy policy is also subject to the
      the Implementing Rules and Regulations of the National Privacy Commission of the Philippines under the Republic Act No. 10173(DPA). 
      We will notify users when such updates occur.
    </p>

    <p class="h4">What are the information We Collect?</p>
    <p>
      Our system operates by collecting personal and enterprise data, and by utilizing those in our features like job(opening), applicant and
      company searching. It also provides users interfaces like dashboards for business analytics purposes and so on. Some contents are visible to the public such
      as company profile information and job opening information. This means that we do not immediately require personal information from users in order for them
      to use some of our Services. However, we do require user login or user registration when a guest user decides to apply for a job opening.
    </p>

    <p class="h4">Two Types of Users</p>
    <div>
      Our system caters two types of users, company owner/HR and applicant.

      <p>
        Users have levels of privileges. At initial registration, a user is immediately identified as an applicant.
        An applicant can perform Job searching, job application and application tracking. He can also manage his own user account.
      </p>

      <p>
        <strong>These are the following personal inform that we may collect:</strong>
      </p>
      <ul>
        <li>First Name</li>
        <li>Middle Name</li>
        <li>Last Name</li>
        <li>Gender</li>
        <li>Birth Date</li>
        <li>Photo</li>
        <li>Cover Photo</li>
        <li>Resume File</li>
        <li>Personal Description</li>
        <li>Educational Background</li>
        <li>Work Experience</li>
        <li>Address</li>
        <li>Mobile Number</li>
        <li>Skills</li>
      </ul>
      <p>
        When a user registers his own company, he then becomes a company owner. A company owner can perform a number
        of procedures like Job Posting, Applicant Search, etc., in addition to the features that an initial user has.
        But a company owner can also share his administrative privileges to other users. This is an advantage because a company owner can
        then receive help from his HR staff while having a full control and awareness over his companies employee growth.

        These are some of the information we may collect from company owners:
        Company Name
        Email Address
        Description
        Company Employee count
        Opening Details
        Company Hiring Procedures

        Aside from business and personal information, we also collect information from your browser such as IP address, details about the device you are using like
        your operating system and type of device (mobile or desktop). We might also install cookies to your browser. Cookies are small files that
        help us implement security and user identification. Some features, also, might not function well if you block cookies in
        your browser settings. You can disable or enable your browser Cookies settings.
      </p>
    </div>
    
    <p class="h4">How We Use information</p>
    <p>
      The information users provide may be used to analyze trends and statistics and marketing. We may notify you through your email address for validation
      and for informing you of new job opportunities, new features, etc.
    </p>

    <p class="h4">Storage Information</p>
    <p>
      All the information you provide is stored in a fast a secured cloud computing platform. Only through a secure and authorized way can
      our server database be accessed. Your information will be retained unless you decide to delete them.
    </p>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: window.config.appName
  }),

  computed: mapGetters({
    authenticated: 'auth/check'
  })
}
</script>

<style scoped>
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}

.title {
  font-size: 85px;
}
</style>
