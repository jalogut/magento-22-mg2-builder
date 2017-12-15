node {
 	// Clean workspace before doing anything
    deleteDir()

    MAGENTO_DIR=magento

    try {
        stage ('Clone') {
        	checkout scm
        }
        stage ('Install') {
        	sh "composer install"
        }
        stage ('Tests') {
            sh "bin/mg2-builder tests-setup:install -Dproject.name=${BRANCH_NAME} -Ddatabase.admin.username=${DATABASE_USER} -Ddatabase.admin.password=${DATABASE_PASS} -Ddatabase.user=${DATABASE_USER} -Ddatabase.password=${DATABASE_PASS} -DskipDbUserCreation"
	        parallel 'static': {
	            sh "bin/grumphp run"
	        },
	        'unit': {
	            sh "cd ${MAGENTO_DIR}/dev/tests/unit && ../../../../bin/phpunit -c phpunit.xml"
	        },
	        'integration': {
	            sh "cd ${MAGENTO_DIR}/dev/tests/integration && ../../../../bin/phpunit -c phpunit.xml"
	        },
	        failFast: true
        }
        stage ('Artifact') {
             sh "bin/mg2-builder artifact:transfer -Dartifact.name=${BRANCH_NAME} -Dremote.environment=igr -Duse.server.properties"
        }
        if (BRANCH_NAME == 'develop') {
      	    stage ('Deploy') {
                sh "bin/mg2-builder release:deploy -Dremote.environment=igr -Drelease.version=${BRANCH_NAME} -Ddeploy.build.type=artifact"
      	    }
      	}
      	stage ('Clean Up') {
            sh "bin/mg2-builder util:db:clean -Dproject.name=${BRANCH_NAME} -Ddatabase.admin.username=${DATABASE_USER} -Ddatabase.admin.password=${DATABASE_PASS}"
            deleteDir()
        }
    } catch (err) {
        currentBuild.result = 'FAILED'
        throw err
    }
}